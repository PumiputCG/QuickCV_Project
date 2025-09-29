<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; //จัดการข้อมูล request จาก user
use Illuminate\Support\Carbon; //จัดการข้อมูลวัน เวลา (วันที่สมัคร, วันหมดอายุ OTP)
use App\Http\Controllers\AuthController;    //เชื่อมกับ Controller
use App\Http\Controllers\ReportController;  //เชื่อมกับ Controller
use App\Http\Controllers\ProtestController; //เชื่อมกับ Controller
use App\Http\Controllers\ProfileController; //เชื่อมกับ Controller
use App\Http\Middleware\CheckRole; //เชื่อมกับ Middleware Check role
use App\Http\Middleware\PreventMultipleLogin; //เชื่อมกับ Middleware PreventMultipleLogin การล็อคอินซ้อน
use Illuminate\Support\Facades\DB; //ใช้ Query Builder ของ Laravel เพื่อเข้าถึงฐานข้อมูลโดยตรง (กรณีที่ไม่ใช้ Model)
use App\Models\Blacklist; //เชื่อมกับตาราง Blacklist ใน model
use App\Http\Controllers\OtpController;     //เชื่อมกับ Controller
use Illuminate\Support\Facades\Mail; //ใช้สำหรับส่งอีเมลจาก smtp(ตัวส่ง otp) ไปยัง user
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//______________________________________________________ผู้ใช้งานทั่วไป (ไม่ต้อง Login)___________________________________________________________

//1. หน้าหลัก
Route::view('/', 'welcome'); //หน้าล็อคอิน
Route::get('/welcome', function () {
    return view('welcome'); //หน้าล็อคอิน
})->name('welcome');




//2. ระบบสมัครสมาชิก (รับ request จากหน้าเว็บ)
Route::post('/register', [AuthController::class, 'register'])->name('register'); //ส่ง request ไปที่ Controller


//3. ระบบ Log in เข้าสู่ระบบ (รับ request จากหน้าเว็บ)
Route::post('/profile', [AuthController::class, 'loginSubmit']); //หน้า login ใช้ส่ง request ไป Controller


//______________________________________________________ผู้ใช้ที่เป็นสมาชิก (Log in)______________________________________________________________

//4. ระบบแสดงหน้าโปรไฟล์ (Login แล้ว)
Route::get('/profile', [ProfileController::class, 'index'])->middleware(['auth', PreventMultipleLogin::class])->name('profile');//(จำเป็นต้อง login) 


//5. ระบบเพิ่มรายงาน
    //5.1 ตารางแสดง CV
Route::get('/user-reports', [ReportController::class, 'userReports'])
    ->middleware(['auth', PreventMultipleLogin::class])
    ->name('user.reports');

//6. ช่องกรอก CV
Route::get('/newreport', function () {
     return view('newreport'); 
    })->middleware(['auth', PreventMultipleLogin::class])->name('newreport');
    //6.1 รับ request ข้อมูลเพิ่มรายงานจาก user
Route::post('/reports', [ReportController::class, 'store'])->middleware(['auth', PreventMultipleLogin::class])->name('reports.store');//ส่ง request ไปทำงานที่ Controller

//7 แสดง CV
Route::get('/cv/{id}', [ReportController::class, 'showCv'])
    ->middleware(['auth',PreventMultipleLogin::class])
    ->name('cv.show');


//8. ปุ่มดาวโหลด pdf
// routes/web.php
Route::get('/cv/{id}/pdf', [ReportController::class, 'downloadCv'])
     ->middleware(['auth'])
     ->name('cv.pdf');



//9. ระบบแก้ไขข้อมูลส่วนตัว
    //9.1 หน้าแก้ไขข้อมูล
Route::get('/editprofile', [ProfileController::class, 'edit'])->middleware(['auth', PreventMultipleLogin::class])->name('editprofile'); //แสดงหน้าแก้ไขโปรไฟล์ ทำงานที่ controller
    //9.2 ส่ง request แก้ไขแบบ put(แก้ไข้ข้อมูลทั้งหมดในหน้านี้)
Route::put('/updateprofile', [ProfileController::class, 'update'])->middleware(['auth', PreventMultipleLogin::class])->name('updateprofile'); 


//10. ระบบเปลี่ยนพาส
    //10.1 หน้าเปลี่ยนพาส
Route::get('/editpassword', [ProfileController::class, 'editPassword'])->middleware(['auth', PreventMultipleLogin::class])->name('editpassword'); //เปลี่ยนรหัสผ่าน
    //10.2 ส่ง request แก้ไขแบบ put(แก้ไข้ข้อมูลทั้งหมดในหน้านี้)
Route::put('/updatepassword', [ProfileController::class, 'updatePassword'])->middleware(['auth', PreventMultipleLogin::class])->name('updatepassword');//แก้ไขรหัสผ่านแบบ put(แก้ไขทั้งหมด)





//______________________________________________________ออกจากระบบ_________________________________________________________________________

Route::get('/logout', function (Request $request) { //รับ request เมื่อกดปุ่ม logout
    Auth::logout(); //auth ออกจากระบบ และเคลียข้อมูล
    $request->session()->invalidate(); //ลบ session เมื่อล็อคเอ้าท์ (ชุดข้อมูลชั่วคราว)
    $request->session()->regenerateToken();//สร้าง csrf ใหม่ (CSRF Token = ตัวป้องกันการแฮกจากฟอร์มหรือลิงก์ปลอม)
    return redirect('/'); //พากลับหน้าแรก
})->name('logout');



//______________________________________________________ระบบ OTP_________________________________________________________________________

//13. ระบบส่ง otp
    //หน้าส่ง otp (อีเมล)
Route::get('/otp', [OtpController::class, 'showOtpForm'])->name('otp.form')->middleware(['auth']);//แสดงหน้า otp
    //request ของ otp
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.verify'); //ส่ง request

//14.ส่ง OTP อีกรอบ
Route::post('/resend-otp', [OtpController::class, 'resend'])->name('otp.resend');

//15. ทดสอบส่งข้อความไปอีเมล จาก Laravel ไป อีเมล โดยใช้ SMTP ก่อนส่ง
Route::get('/test-email', function() { //ทดสอบการส่งอีเมล
    Mail::raw('ทดสอบการส่งอีเมลจาก Laravel', function($message) {//เนื้อหาอีเมล
        $message->to('konosubarashii2@gmail.com') //ส่งอีเมลไปที่ :
                ->subject('ทดสอบการส่งอีเมล');//หัวเรื่อง
    });

    return "ทดสอบสำเร็จ"; //แสดงข้อความบนเว็บ
});




