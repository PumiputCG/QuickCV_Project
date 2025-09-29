<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; //เชื่อมกับ factory
use Illuminate\Foundation\Auth\User as Authenticatable; //รองรับการ login โดย Auth
use Illuminate\Notifications\Notifiable; //สามารถส่งแจ้้งเตือนได้ ใช้กับ OTP

class AppUser extends Authenticatable //ขอเชื่อมเพื่อรองรับการ login (เป็น framework จาก laravel)
{
    use HasFactory, Notifiable; //ขอใช้ factory และ การแจ้งเตือน

    protected $table = 'app_users'; //กำหนดชื่อให้ใหม่เพราะ laravel หา _ (underscore ไม่เจอ)

    // เรียกใช้ตัวแปรในตาราง
    protected $fillable = [
        'username', 'email', 'password', 'telephone', 'role' , 'email_verified',
    'otp',
    'otp_expiry','session_id',
    ];

    // ซ่อนข้อมูลจาก API (ถ้าไม่ซ่อนจะโดนแฮ็คได้ กดF12ดู API เว็บ)
    protected $hidden = [
        'password', 'remember_token',
    ];

    // เปลี่ยนชนิดตัวแปร
    protected $casts = [
        'email_verified_at' => 'datetime',
    'email_verified' => 'boolean', //(0=ไม่ยืนยัน,1=ยืนยันแล้ว)
    'otp_expiry' => 'datetime',
    ];

    public function protests() //เป็นฟังก์ชันแม่ เพื่อให้ Protest ใช้ foreign key
    {
        return $this->hasMany(Protest::class); //1user มีได้ หลาย protests
    }

    public function blacklists() //เป็นฟังก์ชันแม่ เพื่อให้ Blacklist ใช้ foreign key
    {
        return $this->hasMany(Blacklist::class); //// 1 User มีหลาย Blacklist
    }
}
