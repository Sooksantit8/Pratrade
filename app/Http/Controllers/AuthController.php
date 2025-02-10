<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * แสดงฟอร์มการเข้าสู่ระบบ
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * ฟังก์ชันสำหรับเข้าสู่ระบบ
     * ตรวจสอบข้อมูลผู้ใช้และเข้าสู่ระบบหากข้อมูลถูกต้อง
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลที่กรอก
        $request->validate([
            'Username' => 'required', // ตรวจสอบว่า Username ถูกกรอก
            'Password' => 'required', // ตรวจสอบว่า Password ถูกกรอก
        ]);

        // รับค่า Username และ Password จาก request
        $credentials = $request->only('Username', 'Password');

        // ตรวจสอบว่า Username ที่กรอกเป็นอีเมลหรือไม่
        $fieldType = filter_var($credentials['Username'], FILTER_VALIDATE_EMAIL) ? 'Email' : 'Username';

        // ตรวจสอบข้อมูลผู้ใช้ในระบบและเข้าสู่ระบบหากข้อมูลถูกต้อง
        if (Auth::attempt([$fieldType => $credentials['Username'], 'password' => $credentials['Password'], 'Active' => 1])) {
            $user = Auth::user(); // รับข้อมูลผู้ใช้ที่เข้าสู่ระบบ

            // ถ้าสำเร็จ, เปลี่ยนเส้นทางไปยังหน้าเดิมที่ผู้ใช้ต้องการพร้อมข้อความสำเร็จ
            return redirect()->intended('/')->with('success', 'เข้าสู่ระบบสำเร็จ');
        }

        // ถ้าข้อมูลไม่ถูกต้อง, กลับไปที่หน้าเดิมพร้อมข้อผิดพลาด
        return back()->with('error', 'Username/Email หรือรหัสผ่านไม่ถูกต้อง!');
    }

    /**
     * ฟังก์ชันสำหรับออกจากระบบ
     * ทำการ logout ผู้ใช้
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout(); // ทำการ Logout ผู้ใช้

        // Redirect ไปยังหน้า Login หรือหน้าอื่นที่ต้องการ
        return redirect('/');
    }
}
