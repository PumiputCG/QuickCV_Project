{{-- resources/views/cv/show.blade.php --}}
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CV #{{ $cv->id ?? '' }}</title>

  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root{
      --ink:#0b0f19;
      --muted:#58627a;
      --brand:#0a165f;
      --white:#ffffff;
      --blue:#1a73e8;
      --line:#d1d5db;
      --sheet:#ffffff;
      --maxw:980px;
    }

    *{ box-sizing:border-box; }
    html,body{ margin:0; padding:0; background:#f3f4f6; color:var(--ink); font-family:'Prompt',system-ui,sans-serif; }
    .cv-wrap{ max-width:var(--maxw); margin:28px auto; background:var(--sheet); box-shadow:0 8px 28px rgba(2,6,23,.08); }

    /* ===== Header ===== */
    .cv-header{
      background:var(--brand); color:var(--white);
      padding:28px 32px 22px; display:grid; grid-template-columns:160px 1fr; gap:24px; align-items:start;
    }
    .avatar{ width:160px; height:200px; object-fit:cover; border-radius:8px; background:#0d1a6b; border:2px solid rgba(255,255,255,.15); }
    .name-row{ display:flex; align-items:baseline; gap:10px; flex-wrap:wrap; }
    .name-row .name{ font-weight:800; font-size:28px; letter-spacing:.2px; }
    .name-row .nick{ font-weight:700; font-size:22px; opacity:.9; }

    .meta{ margin-top:10px; line-height:1.45; display:grid; grid-template-columns:1fr auto; gap:2px 16px; font-size:13px; letter-spacing:.12em; text-transform:uppercase; }
    .meta .label{ opacity:.85; }
    .meta .right{ text-align:right; }
    .addr{ margin-top:10px; font-size:13px; opacity:.92; }

    /* intro */
    .intro{ padding:14px 32px 26px; color:var(--white); background:var(--brand); border-top:1px solid rgba(255,255,255,.12); font-size:15px; line-height:1.7; }

    /* ===== Body ===== */
    .cv-body{ padding:26px 40px 40px; background:var(--sheet); }
    .section{ margin-top:28px; }
    .section .title{ font-weight:700; color:#263041; font-size:15px; margin-bottom:10px; }
    .dash{ border:0; border-top:1px dashed var(--line); margin:0 0 14px 0; }
    .skill-content{ color:var(--blue); font-weight:700; font-size:18px; line-height:1.7; white-space:pre-line; }
    .text{ color:#1f2937; white-space:pre-line; line-height:1.9; }

    /* รูปหัวข้อ 1–4 */
    .section-image{
      display:block; margin:18px auto; max-width:86%; height:auto;
      border-radius:10px; box-shadow:0 10px 30px rgba(10,22,95,.18);
    }

    /* ปุ่มกลับ */
    .back{ text-align:center; padding:16px 0 28px; }
    .btn{ display:inline-block; padding:.65rem 1.1rem; border-radius:10px; text-decoration:none; font-weight:600; border:1px solid #111827; color:#fff; background:#111827; }

    @media print{ body{ background:#fff; } .cv-wrap{ box-shadow:none; margin:0; } .back{ display:none; } }
  </style>
</head>
<body>

@php
  // ดึง path รูปจาก JSON
  $pp   = is_array($cv->profile_picture) ? ($cv->profile_picture['path'] ?? null) : $cv->profile_picture;
  $img1 = is_array($cv->section1_image)  ? ($cv->section1_image['path']  ?? null) : $cv->section1_image;
  $img2 = is_array($cv->section2_image)  ? ($cv->section2_image['path']  ?? null) : $cv->section2_image;
  $img3 = is_array($cv->section3_image)  ? ($cv->section3_image['path']  ?? null) : $cv->section3_image;
  $img4 = is_array($cv->section4_image)  ? ($cv->section4_image['path']  ?? null) : $cv->section4_image;
@endphp

<div class="cv-wrap">

  <!-- ===== HEADER ===== -->
  <div class="cv-header">
    <div>
      <img class="avatar"
           src="{{ $pp ? asset($pp) : 'https://via.placeholder.com/160x200?text=Profile' }}"
           alt="Profile Picture">
    </div>

    <div>
      <div class="name-row">
        <div class="name">{{ $cv->name ?? '-' }}&nbsp;&nbsp;{{ $cv->lastname ?? '-' }}</div>
        @if(!empty($cv->nickname)) <div class="nick">({{ $cv->nickname }})</div> @endif
      </div>

      <div class="meta">
        <div class="label">Education</div> <div class="right">( major )</div>
        <div class="value">{{ $cv->education ?? '-' }}</div> <div class="right">{{ $cv->major ?? '-' }}</div>

        <div class="label">company</div>  <div class="right">&nbsp;</div>
        <div class="value">{{ $cv->company ?? '-' }}</div> <div class="right">&nbsp;</div>

        <div class="label">age</div> <div class="right">&nbsp;</div>
        <div class="value">{{ $cv->age ?? '-' }}</div> <div class="right">&nbsp;</div>
      </div>

      @if(!empty($cv->address))
        <div class="addr">address&nbsp;&nbsp;{{ $cv->address }}</div>
      @endif
    </div>
  </div>

  @if(!empty($cv->introduce))
    <div class="intro">{!! nl2br(e($cv->introduce)) !!}</div>
  @endif

  <!-- ===== BODY ===== -->
  <div class="cv-body">

    <!-- Programming Skills -->
    <section class="section">
      <div class="title">Programing Skills</div>
      <hr class="dash">
      <div class="skill-content">{{ $cv->skill_programming ?? '' }}</div>
    </section>

    <div style="height:120px;"></div>

    <!-- General Skills -->
    <section class="section">
      <div class="title">General Skills</div>
      <hr class="dash">
      <div class="text">{{ $cv->general_skill ?? '' }}</div>
    </section>

    <!-- Activities -->
    <section class="section">
      <div class="title">Activities</div>
      <hr class="dash">
      <div class="text">{{ $cv->activity ?? '' }}</div>
    </section>

    <!-- Experience -->
    <section class="section">
      <div class="title">Experience</div>
      <hr class="dash">
      <div class="text">{{ $cv->experience ?? '' }}</div>
    </section>

    <!-- Section 1 -->
    @if(!empty($cv->section1_title) || $img1)
    <section class="section">
      <div class="title">{{ $cv->section1_title ?: 'Section 1' }}</div>
      <hr class="dash">
      @if($img1)
        <img src="{{ asset($img1) }}" class="section-image" alt="section1_image">
      @endif
    </section>
    @endif>

    <!-- Section 2 -->
    @if(!empty($cv->section2_title) || $img2)
    <section class="section">
      <div class="title">{{ $cv->section2_title ?: 'Section 2' }}</div>
      <hr class="dash">
      @if($img2)
        <img src="{{ asset($img2) }}" class="section-image" alt="section2_image">
      @endif
    </section>
    @endif

    <!-- Section 3 -->
    @if(!empty($cv->section3_title) || $img3)
    <section class="section">
      <div class="title">{{ $cv->section3_title ?: 'Section 3' }}</div>
      <hr class="dash">
      @if($img3)
        <img src="{{ asset($img3) }}" class="section-image" alt="section3_image">
      @endif
    </section>
    @endif

    <!-- Section 4 -->
    @if(!empty($cv->section4_title) || $img4)
    <section class="section">
      <div class="title">{{ $cv->section4_title ?: 'Section 4' }}</div>
      <hr class="dash">
      @if($img4)
        <img src="{{ asset($img4) }}" class="section-image" alt="section4_image">
      @endif
    </section>
    @endif

  </div>
</div>

<div class="back" style="display:flex; gap:10px; justify-content:center;">
  <a href="{{ route('cv.pdf', $cv->id) }}" class="btn">ดาวน์โหลด PDF</a>
  
</div>


<div class="back">
  <a href="{{ url('/user-reports') }}" class="btn">กลับไปหน้าตาราง</a>
</div>

</body>
</html>
