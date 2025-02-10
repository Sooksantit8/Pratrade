<?php

namespace App\Http\Controllers;

use App\Models\TBCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index');
    }

    public function getCategories(Request $request)
    {
        if ($request->ajax()) {
            $query = TBCategory::where('Parent_id',null);

            if ($request->has('search_categoryname')) {
                $query->where('Category_name', 'like', "%$request->search_categoryname%");
            }

            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    return '
                    <div class="action-btn">
                        <a href="/categories/edit/' .
                        $row->ID .
                        '" class="text-dark edit" ata-id="' .
                        $row->ID .
                        '">
                        <i class="ti ti-edit fs-5"></i>
                        </a>
                        <a href="javascript:void(0)" class="text-dark delete ms-2" onclick="deletecategory(\'' .
                        $row->ID .
                        '\')">
                        <i class="ti ti-trash fs-5"></i>
                        </a>
                    </div>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        $ID = Str::uuid();
        // ส่งข้อมูลไปยัง View
        return view('categories.create', compact('ID'));
    }

    public function insertCategory(Request $request)
    {
        DB::beginTransaction();
        try {

            // รับข้อมูลหมวดหมู่ที่ส่งมาจากฟอร์ม
            $categories = $request->input('Category_name');

            foreach ($categories as $key => $value) {
                $category = new TBCategory();
                $category->ID = $key;
                $category->Category_name = $request->Category_name[$key];
                $category->Level = $request->Level[$key];
                $category->Active = 1;
                $category->Main_id = $request->Main_id;
                $category->Parent_id = $request->Parent_id[$key];
                $category->Sortorder = $request->Sortorder[$key];
                $category->Create_by = Auth::user()->Username; // อาจจะใช้ auth()->user()->name แทน
                $category->Create_date = now();

                $category->save();
            }
            DB::commit();
            // ส่ง Response กลับไป
            return response()->json([
                'success' => true,
                'message' => 'บันทึกข้อมูลสำเร็จ!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); 
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

    public function edit($id)
    {
        // ดึงข้อมูลหมวดหมู่ทั้งหมดเพื่อใช้ในการแสดง
        $categories = TBCategory::where('Main_id', $id)->orderBy('Sortorder', 'asc')->get();
        // ส่งข้อมูลไปยัง View
        return view('categories.create', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            TBCategory::where('Main_id', $id)->delete();

            // รับข้อมูลหมวดหมู่ที่ส่งมาจากฟอร์ม
            $categories = $request->input('Category_name');

            foreach ($categories as $key => $value) {
                $category = new TBCategory();
                $category->ID = $key;
                $category->Category_name = $request->Category_name[$key];
                $category->Level = $request->Level[$key];
                $category->Active = 1;
                $category->Main_id = $id;
                $category->Parent_id = $request->Parent_id[$key];
                $category->Sortorder = $request->Sortorder[$key];
                $category->Create_by = Auth::user()->Username; // อาจจะใช้ auth()->user()->name แทน
                $category->Create_date = now();

                $category->save();
            }


            DB::commit();
            // ส่ง Response กลับไป
            return response()->json([
                'success' => true,
                'message' => 'แก้ไขข้อมูลสำเร็จ!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); 
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

    public function destroy($id)
    {
        try {
            // ค้นหาข้อมูลหมวดหมู่
            $category = TBCategory::find($id);
            // ลบหมวดหมู่
            $category->delete();

            // ส่ง Response กลับไป
            return response()->json([
                'success' => true,
                'message' => 'แก้ไขข้อมูลสำเร็จ!',
            ]);
        } catch (\Exception $e) {
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
