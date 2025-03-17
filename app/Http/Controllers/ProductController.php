<?php
namespace App\Http\Controllers;

use App\Models\TBBookbank;
use App\Models\TBProducts;
use App\Models\TBLookup;
use App\Models\TBImage_Product;
use App\Models\TBCategory;
use App\Models\TBProduct_Category;
use App\Models\TBCart_Product;
use App\Models\TBPackage;
use App\Models\TBUser_Package_History;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DataTables;

class ProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = TBCategory::where('Active', 1)->orderBy('Category_name', 'asc')->get();
        return view('products.index', compact('categories'));
    }

    public function myproduct()
    {
        $preorders = TBLookup::where('Lookup_type', 'Preorder_status')->get();
        return view('products.myproduct',compact('preorders'));
    }

    public function getProduct(Request $request)
    {

        if ($request->ajax()) {
            $query = TBProducts::where('Active', 1)
                ->where('Create_by', Auth::user()->Username)
                ->with('Preorderstatus', 'Substatusproduct');

            if ($request->has('search_productname')) {
                $query->where('Product_Name', 'like', "%$request->search_productname%");
            }

            if ($request->has('search_statusproduct')) {
                $query->where('Preorder', 'like', "$request->search_statusproduct%");
            }
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    return '
                    <div class="action-btn">
                        <a href="/myproduct/edit/' .
                        $row->ID .
                        '" class="text-dark edit" ata-id="' .
                        $row->ID .
                        '">
                        <i class="ti ti-edit fs-5"></i>
                        </a>
                        <a href="javascript:void(0)" class="text-dark delete ms-2" onclick="deleteproduct(\'' .
                        $row->ID .
                        '\')">
                        <i class="ti ti-trash fs-5"></i>
                        </a>
                    </div>
                ';
                })
                ->addColumn('Substatusproduct', function ($row) {
                    $Substatusproduct = "";
                    if ($row->Preorder == "PRE2") {
                        $str_substatus = "อัพเดทสถานะ";
                        if (($row->Substatusproduct->Lookup_name ?? "") != "") {
                            $str_substatus = $row->Substatusproduct->Lookup_name;
                        }
                        $Substatusproduct = '<a href="javascript:void(0)" class="edit" data-id="' .
                            $row->ID .
                            '" style="color: #5d87ff;">
                        ' .
                            $str_substatus .
                            '
                        </a>';
                    }
                    return $Substatusproduct;
                })
                ->addColumn('Preorderstatus', function ($row) {
                    return $row->Preorderstatus->Lookup_name ?? "";
                })
                ->rawColumns(['action', 'Substatusproduct'])
                ->make(true);
        }
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

        $mypackage = TBPackage::where('ID',Auth::user()->Package)->first();
        $bookbank = TBBookbank::where('From','user')
        ->where('Active',1)
        ->where('Create_by', Auth::user()->Username)->get();

        // ส่งข้อมูลไปยัง View
        return view('products.create', compact('preorders', 'categories','mypackage','bookbank'));
    }

    public function edit($id)
    {
        $product = TBProducts::with('images')->findOrFail($id);
        
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

        $mypackage = TBPackage::where('ID',Auth::user()->Package)->first();
        $bookbank = TBBookbank::where('From','user')
        ->where('Active',1)
        ->where('Create_by', Auth::user()->Username)->get();

        $product_category = TBProduct_Category::where('Product_ID',$id)->pluck('Category_ID')->toArray();;
        $images = TBImage_Product::where('ProductID', $id)->get()->map(function ($image) {
            // สร้างเส้นทางในเครื่องเซิร์ฟเวอร์
            $imagePath = storage_path('app/public/' . $image->Path_Image);
        
            // คืนค่าผลลัพธ์
            return [
                "id" => $image->ID,
                "name" => basename($image->Path_Image),
                "size" => file_exists($imagePath) ? filesize($imagePath) : 0, // ตรวจสอบว่ามีไฟล์ก่อนหาขนาด
                "url"  => asset('storage/' . $image->Path_Image) // ใช้ asset เพื่อสร้าง URL
            ];
        });
        // ส่งข้อมูลไปยัง View
        return view('products.create', compact('preorders', 'categories','mypackage','bookbank','product','product_category','images'));
    }

    public function insertProduct(Request $request)
    {
        DB::beginTransaction(); // เริ่มการทำธุรกรรม
        try {
            $Main_Product = "";
            if(isset($request->ID) && $request->ID != ""){
                $Product = TBProducts::find($request->ID);
                TBProducts::where('Main_Product', $Main_Product)
                ->orWhere('Main_Product',$Product->Main_Product)
                ->update(['Is_latest' => 0, 'Update_date' => now(),'Update_by'=>Auth::user()->Username]);
                if(isset($Product->Main_Product) && $Product->Main_Product != ""){
                    $Main_Product = $Product->Main_Product;
                }else{
                    $Main_Product = $request->ID;
                }
            }

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
            $product->Main_Product = $Main_Product;
            $product->Is_latest = 1;
            if($request->UseCentralfunction == "notuse"){
                $product->Use_Central_function = 0;
                if($request->bookbank != ""){
                    $product->bookbank = $request->bookbank;
                }else{
                    $bookbank = new TBBookbank();
                    $bookbank->Bookbanknumber = $request->Bookbanknumber;
                    $bookbank->Bookbankname = $request->Bookbankname;
                    $bookbank->Bankname = $request->Bankname;
                    $bookbank->Active = 1;
                    $bookbank->From = $request->From;
                    $bookbank->Create_by = Auth::user()->Username;
                    $bookbank->Create_date = now();
                    if ($request->hasFile('Path_Image')) {
                        $path = $request->file('Path_Image')->store('bookbank_images', 'public');
                        $bookbank->Path_Image = $path;
                    }
                    $bookbank->save();

                    $product->bookbank = $bookbank->ID;
                }
            }else{
                $product->Use_Central_function = 1;
                $bookbankcentral = TBBookbank::where('Active',1)
                ->where("Used",1)
                ->where('From','admin')
                ->first();

                $product->bookbank = $bookbankcentral->ID;
            }
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

            if(isset($request->ID) && $request->ID != ""){
                $Image_Product = TBImage_Product::where('ProductID',$request->ID)->get();

                foreach($Image_Product as $itemimg){
                    $addimageData = new TBImage_Product();
                    $addimageData->ProductID = $product->ID;
                    $addimageData->Path_Image = $itemimg->Path_Image;
                    $addimageData->Type = $itemimg->Type;
                    $addimageData->Name_old = $itemimg->Name_old;
                    $addimageData->Name_new = $itemimg->Name_new;
                    $addimageData->Active = 1;
                    $addimageData->Create_by = Auth::user()->Username; // อาจจะใช้ auth()->user()->name แทน
                    $addimageData->Create_date = now();
                    $addimageData->save();
                }
            }

            // บันทึกไฟล์ภาพใน TBImage_Product
            if ($request->hasFile('images')) {
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

    public function addCart($id,Request $request)
    {
        try {
            $cartProduct = TBCart_Product::where('Username',Auth::user()->Username)
            ->where('Product_ID',$id)->first();

            if ($cartProduct) {
                $cartProduct->delete();  // ลบข้อมูล
            }
            $product = TBProducts::with('images')->findOrFail($id);
            $addcart = new TBCart_Product();
            $addcart->Username = Auth::user()->Username;
            $addcart->Product_ID = $id;
            $addcart->Qty = $request->Qty;
            $addcart->Shop_ID = $product->Create_by;
            $addcart->Create_by = Auth::user()->Username;
            $addcart->Create_date = now();
            $addcart->save();

            return response()->json([
                'success' => true,
                'message' => 'บันทึกข้อมูลสำเร็จ!',
            ]); 
        }catch (\Exception $e) {
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

    public function Showcart()
    {
        try {
            $cartProducts = TBCart_Product::where('Username',Auth::user()->Username)
            ->with('Shop','product.images','product.categorys')
            ->get();

            return view('partials.shopping_cartdetail', compact('cartProducts'));
        }catch (\Exception $e) {
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
}
