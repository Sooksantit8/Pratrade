<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\TBUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class FacebookAuthController extends Controller
{
    /**
     * Redirect to Facebook login page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToFacebook()
    {
        // ส่งผู้ใช้ไปยังหน้า Facebook login
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handle Facebook callback
     * รับข้อมูลจาก Facebook และทำการเข้าสู่ระบบหากยังไม่สมัครสมาชิกในระบบ
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleFacebookCallback()
    {
        try {
            // รับข้อมูลผู้ใช้งานจาก Facebook เช่น ชื่อ, อีเมล, และ ID
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            // ตรวจสอบและสร้างผู้ใช้งานในระบบหากยังไม่มีข้อมูลผู้ใช้งานนี้
            $user = TBUser::firstOrCreate(
                [
                    'Username' => $facebookUser->getId(), // ใช้ Facebook ID เป็น Username
                ],
                [
                    // ข้อมูลที่ต้องการเก็บในระบบ
                    'Firstname' => $facebookUser->getName(), // ชื่อจาก Facebook
                    'Email' => $facebookUser->getEmail(), // อีเมลจาก Facebook
                    'Tel' => null, // เบอร์โทรไม่สามารถดึงจาก Facebook ได้
                    'Package' => null, // ตั้งค่าฟิลด์ Package เป็นค่าเริ่มต้น
                    'Permission_Code' => "P02", // ตั้งค่าฟิลด์ Permission_Code เป็นค่าเริ่มต้น
                    'Status' => "S02", // สถานะผู้ใช้
                    'Is_Reject' => false, // กำหนดสถานะการยกเลิกเป็น false
                    'Active' => true, // กำหนดให้ผู้ใช้งานเป็น active
                    'Create_by' => 'Facebook', // กำหนดว่าแหล่งข้อมูลมาจาก Facebook
                    'Create_date' => now(), // วันที่สร้างบัญชีผู้ใช้
                    'Update_by' => 'Facebook', // กำหนดว่าแหล่งข้อมูลในการอัปเดตมาจาก Facebook
                    'Update_date' => now(), // วันที่อัปเดตข้อมูลล่าสุด
                ]
            );

            // เข้าสู่ระบบด้วยข้อมูลที่ได้รับจาก Facebook
            Auth::login($user);

            // เปลี่ยนเส้นทางไปยังหน้า Dashboard หรือหน้าที่ต้องการ
            return redirect('/')->with('success', 'เข้าสู่ระบบสำเร็จ');
        } catch (\Exception $e) {
            // ถ้ามีข้อผิดพลาดเกิดขึ้น, จะแสดงข้อความผิดพลาด
            return response()->json($e->getMessage());

            // ส่งกลับไปยังหน้า login พร้อมแสดงข้อผิดพลาด
            return redirect('/login')->with('error', 'ไม่สามารถเข้าสู่ระบบด้วย Facebook ได้');
        }
    }
}
