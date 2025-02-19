<?php
namespace App\Http\Controllers;

use App\Models\TBProducts;
use App\Models\TBLookup;
use App\Models\TBImage_Product;
use App\Models\TBCategory;
use App\Models\TBProduct_Category;
use App\Models\TBUser_Package_History;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = TBCategory::where('Active', 1)->orderBy('Category_name', 'asc')->get();
        return view('products.index', compact('categories'));
    }
    // แสดงรายการสินค้า
    public function table_product(Request $request)
    {
        $products = TBProducts::with('images')->paginate(6); // แบ่งหน้า 6 รายการต่อครั้ง
        if ($request->ajax() && $products->count() > 0) {
            return view('products.table_product', compact('products'))->render(); // ส่งเฉพาะ HTML การ์ดกลับไป
        }
    }

    // แสดงหน้าฟอร์มสร้างสินค้าใหม่
    public function create()
    {
        $package_history = TBUser_Package_History::with('package')
        ->where('Username', Auth::user()->Username)
        ->where('Status', 'S02')
        ->where('Active', 1)
        ->orderBy('Create_date', 'desc')
        ->first();

        $CountPost = TBProducts::where('Create_by', Auth::user()->Username)
        ->where('Active', 1)
        ->count();


        if((Auth::user()->Status != 'S02' || Auth::user()->Package == '' || Auth::user()->Package == null || ($package_history->package->Qty_Post - $CountPost) <= 0) && Auth::user()->Permission_Code != 'P01'){
            return redirect()->route('product.pricing');
        }
        // Query ข้อมูลจากฐานข้อมูล
        $preorders = TBLookup::where('Lookup_type', 'Preorder_status')->get();
        $categories = TBCategory::where('Active', 1)->orderBy('Category_name', 'asc')->get();

        // ส่งข้อมูลไปยัง View
        return view('products.create', compact('preorders', 'categories'));
    }

    public function insertProduct(Request $request)
    {
        DB::beginTransaction(); // เริ่มการทำธุรกรรม
        try {
            $category = $array = explode(',', $request->Category);
            // บันทึกข้อมูลสินค้า
            $product = new TBProducts();
            $product->Product_name = $request->Product_name;
            $product->Price = $request->Price;
            $product->Stock_qty = $request->Stock_qty;
            $product->Preorder = $request->Preorder;
            $product->Preorder_date = $request->Preorder_date ?? null;
            $product->Price_Preorder = $request->Price_Preorder ?? null;
            $product->Description = $request->Description;
            $product->Product_model = $request->Product_model ?? null;
            $product->Product_materials = $request->Product_materials ?? null;
            $product->Manufacturer = $request->Manufacturer ?? null;
            $product->Year_manufacture = $request->Year_manufacture ?? null;
            $product->Bought_from = $request->Bought_from ?? null;
            $product->Purchase_price = $request->Purchase_price ?? null;
            $product->Active = 1;
            $product->Create_by = Auth::user()->Username;
            $product->Create_date = now();
            $product->save();

            foreach ($category as $categoryitem) {
                $categoryadd = new TBProduct_Category();
                $categoryadd->Product_ID = $product->ID;
                $categoryadd->Category_ID = $categoryitem;
                $categoryadd->Create_date = now();
                $categoryadd->save();
            }

            // บันทึกไฟล์ภาพใน TBImage_Product
            if ($request->has('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('product_images', 'public'); // เก็บไฟล์ในโฟลเดอร์ 'public/product_images'

                    $imageData = new TBImage_Product();
                    $imageData->ProductID = $product->ID;
                    $imageData->Path_Image = $path;
                    $imageData->Type = $image->getClientMimeType();
                    $imageData->Name_old = $image->getClientOriginalName();
                    $imageData->Name_new = basename($path);
                    $imageData->Active = 1;
                    $imageData->Create_by = Auth::user()->Username; // อาจจะใช้ auth()->user()->name แทน
                    $imageData->Create_date = now();
                    $imageData->save();
                }
            }

            DB::commit(); // ถ้าทุกอย่างทำสำเร็จ ก็ commit ข้อมูลทั้งหมด
            // ส่ง Response กลับไป
            return response()->json([
                'success' => true,
                'message' => 'บันทึกข้อมูลสำเร็จ!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // หากเกิดข้อผิดพลาด, ทำการย้อนกลับการทำธุรกรรม
            // ส่ง Error Response หากเกิดข้อผิดพลาด
            return response()->json(
                [
                    'success' => false,
                    'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    // แสดงหน้าฟอร์มแก้ไขสินค้า
    public function detail($id)
    {
        $product = TBProducts::with('images')->findOrFail($id);
        // ดึงข้อมูลหมวดหมู่สินค้าที่เชื่อมโยงกับ Product_ID
        $product_category = TBProduct_Category::with('category')->where('Product_ID', $id)->get();

        // ใช้ implode เพื่อรวมชื่อหมวดหมู่เป็น string ที่คั่นด้วยเครื่องหมายจุลภาค
        $category_names = $product_category->pluck('category.Category_name')->implode(', ');
        return view('products.detail', compact('product', 'category_names'));
    }

    // // บันทึกสินค้าใหม่ลงฐานข้อมูล
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'Product_name' => 'required',
    //         'Price' => 'required|numeric',
    //         'Category' => 'required',
    //         'Preorder' => 'nullable|boolean',
    //         'Preorder_date' => 'nullable|date',
    //         'Active' => 'nullable|boolean',
    //         'Create_by' => 'nullable|string',
    //         'Create_date' => 'nullable|date',
    //     ]);

    //     // สร้างสินค้าใหม่
    //     Product::create($request->all());

    //     return redirect()->route('products.index')->with('success', 'Product created successfully.');
    // }

    // // แสดงหน้าฟอร์มแก้ไขสินค้า
    // public function edit($id)
    // {
    //     $product = Product::findOrFail($id);
    //     return view('products.edit', compact('product'));
    // }

    // // อัปเดตข้อมูลสินค้าในฐานข้อมูล
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'Product_name' => 'required',
    //         'Price' => 'required|numeric',
    //         'Category' => 'required',
    //         'Preorder' => 'nullable|boolean',
    //         'Preorder_date' => 'nullable|date',
    //         'Active' => 'nullable|boolean',
    //         'Update_by' => 'nullable|string',
    //         'Update_date' => 'nullable|date',
    //     ]);

    //     // ค้นหาสินค้าตาม ID และอัปเดตข้อมูล
    //     $product = Product::findOrFail($id);
    //     $product->update($request->all());

    //     return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    // }

    // // ลบสินค้าออกจากฐานข้อมูล
    // public function destroy($id)
    // {
    //     $product = Product::findOrFail($id);
    //     $product->delete();

    //     return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    // }
}
