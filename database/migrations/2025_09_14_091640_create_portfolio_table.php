<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portfolio', function (Blueprint $table) {
            $table->id();

            // ข้อมูลสั้น
            $table->string('name');
            $table->string('lastname');
            $table->string('nickname')->nullable();
            $table->string('age')->nullable();
            $table->text('address')->nullable();
            $table->string('company')->nullable();
            $table->string('education')->nullable();
            $table->string('major')->nullable();

            // ข้อความยาว -> ใช้ text และให้ nullable
            $table->text('introduce')->nullable();
            $table->text('skill_programming')->nullable();
            $table->text('general_skill')->nullable();
            $table->text('experience')->nullable();
            $table->text('activity')->nullable();

            // รูปโปรไฟล์เป็น JSON
            $table->json('profile_picture')->nullable();

            // หัวข้อ/ภาพ 1–4 (ภาพเก็บเป็น JSON)
            $table->string('section1_title')->nullable();
            $table->json('section1_image')->nullable();

            $table->string('section2_title')->nullable();
            $table->json('section2_image')->nullable();

            $table->string('section3_title')->nullable();
            $table->json('section3_image')->nullable();

            $table->string('section4_title')->nullable();
            $table->json('section4_image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio');
    }
};
