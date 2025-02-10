<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\TBPackage;
use App\Models\TBPermission;
use App\Models\TBStatusUser;
use App\Models\TBUser;
use App\Models\TBUser_Package_History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\TBBookbank;
use DataTables;

class UserController extends Controller
{
    public function index()
    {
        $StatusUser = TBStatusUser::orderBy("Sortorder", "asc")->Where("Active", true)->get();
        return view('user.index', compact("StatusUser"));
    }

    public function getUser(Request $request)
    {
        $query = TBUser::with(['package', 'permission', 'status']);

        // กรองสถานะ
        if ($request->status) {
            $query->where('Status', $request->status);
        }

        // กรอง Username
        if ($request->username) {
            $query->where('Username', 'like', '%' . $request->username . '%');
        }

        // กรองชื่อ-นามสกุล
        if ($request->name) {
            $query->whereRaw("CONCAT(Firstname, ' ', Lastname) LIKE ?", ['%' . $request->name . '%']);
        }

        // กรองเบอร์โทร
        if ($request->tel) {
            $query->where('Tel', 'like', '%' . $request->tel . '%');
        }

        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                return '
            <div class="action-btn">
                <a href="/user/edit/' .
                    $row->ID .
                    '" class="text-dark edit" data-id="' .
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
            ->addColumn('package_name', function ($row) {
                return $row->package->Package_Name ?? '-';
            })
            ->addColumn('permission_name', function ($row) {
                return $row->permission->Permission_Name ?? '-';
            })
            ->addColumn('status_name', function ($row) {
                return $row->status->Status_Name ?? '-';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $Permissions = TBPermission::where('Active', true)->get();
        $Packages = TBPackage::where('Active', true)->get();
        // ส่งข้อมูลไปยัง View
        return view('user.create', compact("Permissions", "Packages"));
    }

    public function insertUser(Request $request)
    {
        try {
            // สร้าง User ใหม่
            $user = new TBUser();
            $user->ID = uniqid(); // ใช้ UUID สำหรับ ID
            $user->Username = $request->Username;
            $user->Password = bcrypt($request->Password); // เข้ารหัสรหัสผ่าน
            $user->Firstname = $request->Firstname;
            $user->Lastname = $request->Lastname;
            $user->Tel = $request->Tel;
            $user->Email = $request->Email;
            $user->Permission_Code = $request->Permission_Code;
            $user->Package = $request->Package;
            $user->Is_Reject = false;
            if ($request->Permission_Code == "P01") {
                $user->Status = "S02";
            }
            $user->Active = true;
            $user->Create_by = Auth::user()->Username ?? 'System'; // กำหนดผู้สร้าง
            $user->Create_date = now();

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'เพิ่มข้อมูล User สำเร็จ'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function paymentPackage($packageid)
    {
        DB::beginTransaction(); // เริ่มการทำธุรกรรม
        try {
            $package = TBPackage::with("lookupTypePost")->findOrFail( $packageid );
            $currentDate = Carbon::now();

            $DateStop = $currentDate;

            if($package->lookupTypePost->Lookup_name2 == "D"){
                $DateStop = $currentDate->addDays(1);
            }else if($package->lookupTypePost->Lookup_name2 == "M"){
                $DateStop = $currentDate->addMonths(1);
            }else if($package->lookupTypePost->Lookup_name2 == "Y"){
                $DateStop = $currentDate->addYears(1);
            }

            if($package->Price == 0){
                $Package_History = new TBUser_Package_History();
                $Package_History->Username = Auth::user()->Username;
                $Package_History->Package = $packageid;
                $Package_History->Approve_By = "System";
                $Package_History->Date_Start = $currentDate;
                $Package_History->Date_Stop = $DateStop;
                $Package_History->Status = "S02";
                $Package_History->Active = true;
                $Package_History->Create_by = Auth::user()->Username;; // อาจจะใช้ auth()->user()->name แทน
                $Package_History->Create_date = now();
                $Package_History->save();

                $user = TBUser::findOrFail( Auth::user()->Username);
                $user->Package = $packageid;
                $user->Status = "S02";
                $user->save();
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

    public function purpayment($packageid)
    {
        $bookbank = TBBookbank::where('Active',1)->where("Used",1)->first();
        $package = TBPackage::where('Active',1)->where("id",$packageid)->first();
        return view('pricing.payment', compact("package","bookbank"));
    }
}
