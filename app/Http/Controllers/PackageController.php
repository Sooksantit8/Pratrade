<?php
namespace App\Http\Controllers;

use App\Models\TBPackage;
use App\Models\TBLookup;
use App\Models\TBUser_Package_History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DataTables;

class PackageController extends Controller
{
    // แสดงหน้า index ของ package
    public function index()
    {
        return view('package.index');
    }

    // แสดงหน้าราคาของ package พร้อมดึงข้อมูล package และประวัติการใช้งานของผู้ใช้
    public function pricing()
    {
        // ดึงข้อมูล Package ที่ Active พร้อมความสัมพันธ์กับ lookupTypePost
        $package = TBPackage::with("lookupTypePost")->where("Active", true)->get();

        // ดึงประวัติ package ที่ผู้ใช้เคยใช้ และราคาเป็น 0
        $package_history = TBUser_Package_History::with('package')
            ->where('Username', Auth::user()->Username)
            ->whereHas('package', function ($query) {
                $query->where('Price', 0); // เงื่อนไขที่ต้องการใน package
            })->get();

        // ส่งข้อมูลไปยัง view
        return view('pricing.index', compact('package', 'package_history'));
    }

    // ดึงข้อมูล Package สำหรับ DataTable
    public function getPackage(Request $request)
    {
        if ($request->ajax()) {
            // Query ข้อมูล package พร้อม join TBLookup
            $query = DB::table('TBPackage')
                ->join('TBLookup', 'TBPackage.Type_Post', '=', 'TBLookup.Lookup_code')
                ->where('TBLookup.Lookup_type', 'type_post')
                ->select('TBPackage.*', 'TBLookup.Lookup_name', DB::raw("CONCAT(TBPackage.Qty_Post, ' โพส/', TBLookup.Lookup_name) AS Type_Post_Name"))
                ->where("Active", true);

            // เงื่อนไขค้นหา
            if ($request->has('search_package')) {
                $query->where('Package_Name', 'like', "%$request->search_package%");
            }

            // ตรวจสอบการเรียงลำดับ
            if ($request->has('order')) {
                $orderColumnIndex = $request->get('order')[0]['column']; // Index ของ column
                $orderDir = $request->get('order')[0]['dir']; // Asc หรือ Desc
                $orderColumns = $request->get('columns'); // รายชื่อ column ทั้งหมด

                // ดึงชื่อ column ตาม index
                $orderColumnName = $orderColumns[$orderColumnIndex]['data'];

                // จัดการ Sort สำหรับคอลัมน์ Type_Post_Name
                if ($orderColumnName === 'Type_Post_Name') {
                    $query->orderByRaw("CONCAT(TBPackage.Qty_Post, ' โพส/', TBLookup.Lookup_name) $orderDir");
                } else {
                    $query->orderBy($orderColumnName, $orderDir);
                }
            }

            // สร้าง DataTable
            return DataTables::of($query)
                ->addColumn('Type_Post_Name', function ($row) {
                    return $row->Qty_Post . ' โพส/' . $row->Lookup_name;
                })
                ->addColumn('Central', function ($row) {
                    return $row->Central_Function ? '<i class="ti ti-circle-check fs-5"></i>' : '<i class="ti ti-circle-x fs-5"></i>';
                })
                ->addColumn('action', function ($row) {
                    return '
                    <div class="action-btn">
                        <a href="' .
                        route('package.edit', $row->ID) .
                        '" class="text-dark edit">
                            <i class="ti ti-edit fs-5"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="deletePackage(\'' .
                        $row->ID .
                        '\')" class="text-dark delete">
                            <i class="ti ti-trash fs-5"></i>
                        </a>
                    </div>';
                })
                ->rawColumns(['Central', 'action'])
                ->make(true);
        }
    }

    // แสดงหน้าเพิ่มข้อมูล Package
    public function create()
    {
        // ดึงข้อมูล Type_Post จาก TBLookup
        $Type_Post = TBLookup::Where('Lookup_type', 'Type_Post')->get();

        // ส่งข้อมูลไปยัง view
        return view('package.create', compact('Type_Post'));
    }

    // เพิ่มข้อมูล Package
    public function insertPackage(Request $request)
    {
        try {
            // บันทึกข้อมูลในฐานข้อมูล
            TBPackage::create([
                'Package_Name' => $request->Package_Name,
                'Price' => $request->Price,
                'Qty_Post' => $request->Qty_Post ?? 0, // ใช้ 0 หากไม่มีค่า
                'Type_Post' => $request->Type_Post,
                'Central_Function' => $request->Central_Function, // ค่า 0 หรือ 1
                'Create_by' => Auth::user()->Username,
                'Active' => 1,
                'Create_date' => now(),
            ]);

            // ส่ง Response สำเร็จ
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

    // แสดงหน้าแก้ไขข้อมูล Package
    public function edit($id)
    {
        // ค้นหา Package ด้วย ID
        $package = TBPackage::findOrFail($id);

        // ดึงข้อมูล Type_Post จาก TBLookup
        $Type_Post = TBLookup::Where('Lookup_type', 'Type_Post')->get();

        // ส่งข้อมูลไปยัง view
        return view('package.create', compact('package', 'Type_Post'));
    }

    // อัพเดตข้อมูล Package
    public function update(Request $request, $id)
    {
        try {
            // ค้นหาข้อมูล Package
            $package = TBPackage::find($id);
            if ($package) {
                // ทำการอัพเดตข้อมูล
                $package->update([
                    'Package_Name' => $request->Package_Name,
                    'Price' => $request->Price,
                    'Qty_Post' => $request->Qty_Post ?? 0, // ใช้ 0 หากไม่มีค่า
                    'Type_Post' => $request->Type_Post,
                    'Central_Function' => $request->Central_Function, // ค่า 0 หรือ 1
                    'Update_by' => Auth::user()->Username,
                    'Active' => 1,
                    'Update_date' => now(),
                ]);

                // ส่ง Response สำเร็จ
                return response()->json([
                    'success' => true,
                    'message' => 'อัพเดตข้อมูลสำเร็จ!',
                ]);
            } else {
                // หากไม่พบข้อมูล
                return response()->json([
                    'success' => false,
                    'message' => 'ไม่พบข้อมูลที่ต้องการอัพเดต!',
                ], 404);
            }
        } catch (\Exception $e) {
            // ส่ง Error Response หากเกิดข้อผิดพลาด
            return response()->json(
                [
                    'success' => false,
                    'message' => 'เกิดข้อผิดพลาดในการอัพเดตข้อมูล: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    // ลบข้อมูล Package (เปลี่ยน Active เป็น 0)
    public function destroy($id)
    {
        try {
            // ค้นหาข้อมูล Package
            $package = TBPackage::find($id);

            if ($package) {
                // อัพเดตค่า Active เป็น 0
                $package->update([
                    'Active' => 0,
                    'Update_by' => Auth::user()->Username,
                    'Update_date' => now(),
                ]);

                // ส่ง Response สำเร็จ
                return response()->json([
                    'success' => true,
                    'message' => 'ข้อมูลถูกลบสำเร็จ (เปลี่ยนสถานะเป็นไม่ใช้งาน)',
                ]);
            } else {
                // หากไม่พบข้อมูล
                return response()->json([
                    'success' => false,
                    'message' => 'ไม่พบข้อมูลที่ต้องการลบ!',
                ], 404);
            }
        } catch (\Exception $e) {
            // ส่ง Error Response หากเกิดข้อผิดพลาด
            return response()->json(
                [
                    'success' => false,
                    'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
}