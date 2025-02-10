<?php

namespace App\Http\Controllers;

use App\Models\TBBookbank;
use App\Models\TBCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DataTables;

class BookbankController extends Controller
{
    public function index()
    {
        return view('bookbank.index');
    }

    public function getbookbank(Request $request)
    {
        if ($request->ajax()) {
            $query = TBBookbank::where('Active', 1);

            if ($request->has('search_booknumber')) {
                $query->where('Bookbanknumber', 'like', "%$request->search_booknumber%");
            }

            if ($request->has('search_bookbankname')) {
                $query->where('Bookbankname', 'like', "%$request->search_bookbankname%");
            }

            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    return '
                    <div class="action-btn">
                        <a href="/bookbank/edit/' .
                        $row->ID .
                        '" class="text-dark edit" ata-id="' .
                        $row->ID .
                        '">
                        <i class="ti ti-edit fs-5"></i>
                        </a>
                        <a href="javascript:void(0)" class="text-dark delete ms-2" onclick="deletebookbank(\'' .
                        $row->ID .
                        '\')">
                        <i class="ti ti-trash fs-5"></i>
                        </a>
                    </div>
                ';
                })
                ->addColumn('Used', function ($row) {
                    if ($row->Used == 1) {
                        return '<div class="form-check form-switch py-2">
                                    <input class="form-check-input" type="checkbox" checked data-id="' . $row->ID . '">
                                </div>';
                    } else {
                        return '<div class="form-check form-switch py-2">
                                    <input class="form-check-input" type="checkbox" data-id="' . $row->ID . '">
                                </div>';
                    }
                })
                ->rawColumns(['action', 'Used'])
                ->make(true);
        }
    }

    public function create()
    {
        // ส่งข้อมูลไปยัง View
        return view('bookbank.create');
    }

    public function insertBookbank(Request $request)
    {
        try {
            $bookbank = new TBBookbank();
            $bookbank->Bookbanknumber = $request->Bookbanknumber;
            $bookbank->Bookbankname = $request->Bookbankname;
            $bookbank->Bankname = $request->Bankname;
            $bookbank->Active = 1;
            $bookbank->Create_by = Auth::user()->Username;
            $bookbank->Create_date = now();

            if ($request->hasFile('Path_Image')) {
                $path = $request->file('Path_Image')->store('bookbank_images', 'public');
                $bookbank->Path_Image = $path;
            }

            $bookbank->save();
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
        $bookbank = TBBookbank::findOrFail($id);
        // ส่งข้อมูลไปยัง View
        return view('bookbank.create', compact('bookbank'));
    }

    public function update(Request $request, $id)
    {
        try {
            $bookbank = TBBookbank::findOrFail($id);

            // อัปเดตข้อมูลทั่วไป
            $bookbank->Bookbanknumber = $request->Bookbanknumber;
            $bookbank->Bookbankname = $request->Bookbankname;
            $bookbank->Bankname = $request->Bankname;
            $bookbank->Update_by = Auth::user()->Username ?? 'Admin';
            $bookbank->Update_date = now();

            // หากมีไฟล์ใหม่ ให้ลบไฟล์เก่าและอัปเดตไฟล์ใหม่
            if ($request->hasFile('Path_Image')) {
                // ลบไฟล์เก่า (ถ้ามี)
                if (!empty($bookbank->Path_Image) && Storage::exists('public/' . $bookbank->Path_Image)) {
                    Storage::delete('public/' . $bookbank->Path_Image);
                }

                // บันทึกไฟล์ใหม่
                $path = $request->file('Path_Image')->store('bookbank_images', 'public');
                $bookbank->Path_Image = $path;
            }

            $bookbank->save();

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
            $bookbank = TBBookbank::find($id);
            $bookbank->Active = 0;
            $bookbank->save();

            // ส่ง Response กลับไป
            return response()->json([
                'success' => true,
                'message' => 'ลบข้อมูลสำเร็จ!',
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

    public function Changestatusused(Request $request)
    {
        try {
            TBBookbank::where('Active', 1)
            ->update(['Used' => 0, 'Update_date' => now(),'Update_by'=>Auth::user()->Username]);

            $bookbank = TBBookbank::find($request->id); // ค้นหา record ตาม ID
            if ($bookbank) {
                $bookbank->Used = $request->used; // อัปเดตสถานะ
                $bookbank->Update_by = Auth::user()->Username; // เพิ่มข้อมูลผู้แก้ไข
                $bookbank->Update_date = now(); // เพิ่มวันที่แก้ไข
                $bookbank->save(); // บันทึกข้อมูล

                return response()->json(['success' => true, 'message' => 'สถานะถูกอัปเดตเรียบร้อย']);
            } else {
                return response()->json(['success' => false, 'message' => 'ไม่พบข้อมูล'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
