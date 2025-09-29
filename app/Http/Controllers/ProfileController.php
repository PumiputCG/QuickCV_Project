<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index() //แสดงหน้าโปรไฟล์ user ที่ล็อคอิน
    {
        $user = Auth::user(); //ดึงข้อมูลที่ล็อคอิน เก็บใน $user
        return view('profile',compact('user'));
    }

    public function edit() //หน้าแก้ไขข้อมูล
    {
        return view('editprofile'); //ส่งไปยัง editprofile
    }

    public function update(Request $request)
    {
        $user = Auth::user(); //ดึงข้อมูล user ที่ล็อคอินเก็บใน $user

        $request->validate([ //ตรวจสอบความถูกต้องของ request
            'username' => 'required|unique:app_users,username,'.$user->id,//.$user->id(ใช้ชื่อซ้ำได้)
            'email' => 'required|email|unique:app_users,email,'.$user->id,//$user->id คือใช้ email ซ้ำได้(สำหรับuserที่จะแก้ไขแค่ภาพโปรไฟล์)
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,heic,heif|max:5120'
        ]);

        $user->email = $request->email; //นำ email ตัวใหม่ เก็บใน $user
        $user->username = $request->username; //นำ ชื่อใหม่ เก็บใน username

       if ($request->hasFile('profile_picture')) {
    if ($user->profile_picture) {
        Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
    }

    $fileName = time() . '.' . $request->profile_picture->extension();
    $request->profile_picture->storeAs('profile_pictures', $fileName, 'public'); // **เพิ่ม 'public' ตรงนี้**
    $user->profile_picture = $fileName;
}

        $user->save(); //บันทึกลง database

        return redirect('/profile')->with('success', 'Profile updated successfully');//พาไปหน้า profile แจ้งเตือนสำเร็จ
    }

    public function editPassword()
    {
        return view('editpassword');
    }

    public function updatePassword(Request $request) //รับ request
    {
        $request->validate([ //ตรวจสอบข้อมูลที่รับเข้ามา
            'current_password' => 'required', //รหัสผ่านเก่า
            'new_password' => 'required|string|min:6|confirmed',//รหัสผ่านใหม่, confirmed ต้องมีฟิลอีกตัว
        ]);

        $user = Auth::user();//ดึงข้อมูลใส่ $user

        //เปรียบเทียบรหัสผ่านที่กรอกเข้ามา และ รหัสผ่านในฐานข้อมูล , hash::check ใช้เข้าถึงรหัสผ่านเวลาใช้ hash::make
        if (!Hash::check($request->current_password, $user->password)) { 
            return back()->with('error', 'รหัสผ่านปัจจุบันไม่ถูกต้อง'); //รหัสไม่ตรง แจ้งเตือน
        }

        //นำรหัสผ่านใหม่เข้า hash::make(เพื่อสุ่มรหัส) เก็บใน database 
        $user->password = Hash::make($request->new_password);
        $user->save(); //บันทึก

        //กลับหน้า profile แจ้งเตือนสำเร็จ
        return redirect('/profile')->with('success', 'รหัสผ่านถูกเปลี่ยนเรียบร้อยแล้ว');
    }
}
