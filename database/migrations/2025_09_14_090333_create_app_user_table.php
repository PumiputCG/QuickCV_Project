<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_users', function (Blueprint $table) {
            $table->id();                                // หมายเลขประจำตัวผู้ใช้
            $table->string('username')->unique();        // ชื่อผู้ใช้ (ห้ามซ้ำ)
            $table->string('email')->unique();           // อีเมล (ห้ามซ้ำ)
            $table->string('telephone')->nullable();     // เบอร์โทร (ว่างได้)
            $table->string('password');                  // รหัสผ่าน (แนะนำให้ hash ตอนบันทึก ไม่ทำใน migration)
            $table->string('role')->default('user');     // บทบาท เริ่มต้น 'user'
            $table->string('profile_picture')->nullable(); // รูปโปรไฟล์ (เก็บ path/URL)
            $table->boolean('email_verified')->default(false); // สถานะยืนยันอีเมล/OTP
            $table->string('otp')->nullable();           // รหัส OTP (ว่างเมื่อยืนยันแล้ว)
            $table->timestamp('otp_expiry')->nullable(); // เวลาหมดอายุ OTP
            $table->string('session_id')->nullable();    // เก็บ session id ถ้าต้องใช้
            $table->timestamps();                        // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_users');
    }
};


