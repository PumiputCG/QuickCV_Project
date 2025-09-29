<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function loginSubmit(Request $request) //รับ request ที่ส่งมาจาก user
    {
        $username = $request->input('username'); 
        $password = $request->input('password');
        
        $user = AppUser::where('username', $username)->first(); //ตรวจสอบ request กับ คอลัมธ์ username ในฐานข้อมูล
        
        if ($user && Hash::check($password, $user->password)) { 
            Auth::login($user); //ล็อคอินเข้าระบบ
            
            //อัปเดต session ผู้ใช้งานที่ login (เก็บผู้ใช้งานล่าสุด)
            $user->update([
                'session_id' => session()->getId(),
            ]);

            if (!$user->email_verified) {//เงื่อนไขนี้สำหรับคนที่ไม่ยืนยันตัวตน
                return redirect('/otp');
            }
            
            return redirect('/profile'); //ถ้ายืนยันแล้ว ไปพาธ/Profile
        } else {
            return back()->with('loginError', true);//แจ้งเตือน loginError
        }
    }

    // In your RegisterController or relevant controller file

    public function register(Request $request) //รับ request ที่ถูกส่งเข้ามา
    {   
        //ตรวจสอบนามสกุลเมล
        $allowedDomains = [ //user ต้องกรอกอีเมลให้ตรงตามนี้
            'gmail.com',
            'yahoo.com',
            'icloud.com',
            'dome.tu.ac.th'
        ];

        Validator::extend('allowed_domain', function ($attribute, $value, $parameters, $validator) use ($allowedDomains) {
            $domain = substr(strrchr($value, "@"), 1); //strrchr เก็บแค่หลัง @ จะได้ "@gmail.com" // substr = ตัด @ ออกจะได้ "gmail.com"
            return in_array($domain, $allowedDomains);
        });

        //แจ้งเตือนกรอกไม่ตรงเงื่อนไข
        $messages = [ 
            'email.allowed_domain' => 'ผู้ใช้งานกรอกอีเมลไม่ตรงเงื่อนไข กรุณาใช้อีเมลที่ลงท้ายด้วย @gmail.com, @yahoo.com, @icloud.com หรือ @dome.tu.ac.th'
        ];

        //ตรวจสอบการสมัคร
        $validatedData = $request->validate([ 
            'username' => 'required|unique:app_users,username', 
            'email' => 'required|email|unique:app_users,email|allowed_domain',
            'password' => 'required|min:6',
        ], $messages); 

        $user = new AppUser(); //สร้าง object โดยดึง model AppUser จะกำหนดให้ :
        $user->username = $validatedData['username']; //รับ username ที่ตรวจสอบแล้ว
        $user->email = $validatedData['email'];//อีเมลที่ตรวจสอบแล้ว
        $user->telephone = ''; 
        $user->password = Hash::make($validatedData['password']); //รับพาสที่ตรวจสอบแล้ว และใช้ hash::make สร้างการรักษาความปลอดภัย
        $user->role = 'user'; //กำหนดให้เป็น user
        $user->email_verified = false; //ยังไม่ยืนยันอีเมล
        $user->otp = Str::random(6); //สุ่ม otp 6 ตัว
        $user->otp_expiry = now()->addMinutes(15);//เวลาหมดอายุ otp 15 นาที

        try { //กรณีถูก
            $user->save(); //บันทึกลงฐานข้อมูล
            $this->sendOtpEmail($user); //เรียกฟังก์ชัน sendOtpEmail($user) เพื่อส่ง otp
            Auth::login($user); //เข้าสู่ระบบทันที (แต่ยังไม่เข้าหน้า profile)
            return redirect('/otp'); //ส่งไปหน้า otp
        } catch (\Exception $e) { //กรณี error
            Log::error('User registration error: ' . $e->getMessage()); //แจ้งเตือน error
            return back()->withErrors(['message' => 'Error registering ' . $e->getMessage()]); //ส่ง error ไปยัง view
        }
    }

    private function sendOtpEmail($user)//รับพารามิเตอร์จาก user
    {
        try {
          
            Mail::send('emails.otp', ['otp' => $user->otp], function($message) use ($user) {
                $message->to($user->email); //อีเมลปลายทาง
                $message->subject('Your OTP for Email Verification'); //หัวข้ออีเมล
            });
        } catch (\Exception $e) {
          
            Log::error('OTP email sending error: ' . $e->getMessage());
            throw $e;
        }
    }
}