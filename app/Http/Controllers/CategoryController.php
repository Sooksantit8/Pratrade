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
            $query = TBCategory::where('Active', 1);

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
        // ส่งข้อมูลไปยัง View
        return view('categories.create');
    }

    public function insertCategory(Request $request)
    {
        try {
            $categories = new TBCategory();
            $categories->Category_name = $request->Category_name;
            $categories->Active = 1;
            $categories->Create_by = Auth::user()->Username;
            $categories->Create_date = now();

            $categories->save();
            // ส่ง Response กลับไป
            return response()->json([
                'success' => true,
                'message' => 'บันทึกข้อมูลสำเร็จ!',
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

    public function edit($id)
    {
        // ดึงข้อมูลหมวดหมู่ทั้งหมดเพื่อใช้ในการแสดง
        $categories = TBCategory::findOrFail($id);
        // ส่งข้อมูลไปยัง View
        return view('categories.create', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            $categories = TBCategory::find($id);
            $categories->Category_name = $request->Category_name;
            $categories->Active = 1;
            $categories->Update_by = Auth::user()->Username;
            $categories->Update_date = now();
            $categories->save();

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

    public function destroy($id)
    {
        try {
            // ค้นหาข้อมูลหมวดหมู่
            $category = TBCategory::find($id);
            $category->Active = 0;
            $category->Update_by = Auth::user()->Username;
            $category->Update_date = now();
            $category->save();

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
