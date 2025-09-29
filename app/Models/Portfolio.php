<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $table = 'portfolio';

    protected $fillable = [
        'name',
        'lastname',
        'nickname',
        'age',
        'address',
        'company',
        'education',
        'major',
        'introduce',
        'skill_programming',
        'general_skill',
        'experience',
        'activity',
        'profile_picture',

        // ฟิลด์ใหม่
        'section1_title',
        'section1_image',
        'section2_title',
        'section2_image',
        'section3_title',
        'section3_image',
        'section4_title',
        'section4_image',
    ];

    protected $casts = [
        // เดิม
        'profile_picture' => 'array',

        // ฟิลด์รูปภาพใหม่ (json)
        'section1_image'  => 'array',
        'section2_image'  => 'array',
        'section3_image'  => 'array',
        'section4_image'  => 'array',
    ];
}
