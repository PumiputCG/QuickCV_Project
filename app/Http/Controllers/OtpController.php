<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function showOtpForm() //แสดงหน้า otp
    {
        return view('otp');
    }

    public function verifyOtp(Request $request) //รับ request
    {
        $user = Auth::user(); //ดึงข้อมูลจาก AppUser
        $otp = $request->input('otp'); //รับ request otp จากผู้ใช้งานที่กรอก

        //otp ที่ผู้ใช้งานกรอก = otp ในคอลัมธ์ AppUser ไหม && now()(วันปัจจุบัน)น้อยกว่า วันหมดอายุ
        if ($user->otp == $otp && $user->otp_expiry > now()) {  //ตรง 2 เงื่อนไขเข้าทำงาน
            $user->email_verified = true;//ผ่านการยืนยันแล้ว จาก false เป็น true ในฐานข้อมูล
            $user->otp = null; //ลบค่า otp ทิ้งในฐานข้อมูล
            $user->otp_expiry = null; //ลบค่า otp หมดอายุทิ้งในฐานข้อมูล
            $user->save(); //บันทึก

            return redirect('/profile')->with('success', 'ยืนยันอีเมลสำเร็จ'); //ไปหน้าโปรไฟล์ แจ้งยืนยันสำเร็จ, 'success' ส่งไปยังจาวาสคริป
        }
        return back()->withErrors(['otp' => 'รหัส OTP ไม่ถูกต้องหรือรหัส OTP หมดอายุ']); //ถ้าไม่เข้าเงื่อนไขบนให้แจ้งเตือน, ส่ง 'otp' ไปจาวาสคริป
    }


    //
     public function resend(Request $request)
    {
        $user = Auth::user();
        
        $user->otp = Str::upper(Str::random(6)); //สุ่มรหัสใหม่แบบตัวอักษร เก็บในคอลัมธ์ otp แทนตัวเก่า (OTP ตัวเก่าจะใช้ไม่ได้แล้ว)
        $user->otp_expiry = now()->addMinutes(15); //เก็บเวลาหมดอายุ 15นาที ใหม่
        $user->save();

        // ส่งอีเมล
        try {
            Mail::send('emails.otp', ['otp' => $user->otp], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Your OTP for Email Verification');
            });

            return back()->with('success', 'ส่ง OTP ใหม่เรียบร้อยแล้ว');
        } catch (\Exception $e) {
            Log::error('OTP resend error: ' . $e->getMessage());
            return back()->with('error', 'เกิดข้อผิดพลาดในการส่ง OTP');
        }
    }

}