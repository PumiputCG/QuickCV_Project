{{-- resources/views/cv/pdf.blade.php --}}
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>CV #{{ $cv->id ?? '' }}</title>
  <style>
    :root{
      --ink:#0b0f19; --muted:#58627a; --brand:#0a165f; --white:#ffffff;
      --blue:#1a73e8; --line:#d1d5db;
    }
    *{ box-sizing:border-box; }

    /* ฟอนต์เล็กลงเล็กน้อย */
    html,body{
      margin:0; padding:0; background:#fff; color:var(--ink);
      font-family:"DejaVu Sans","Tahoma",sans-serif;
      font-size:12px; line-height:1.5;
    }
    .wrap{ width:100%; max-width:700px; margin:0 auto; }

    /* กันการตัดกลางบล็อก */
    .keep{ page-break-inside: avoid; }

    /* ===== Header ===== */
    .header{
      background:var(--brand); color:var(--white);
      padding:14px 18px 12px;
    }
    .head-table{ width:100%; border-collapse:collapse; }
    .head-table td{ vertical-align:top; }
    .avatar{
      width:140px; height:180px; border-radius:6px;
      border:2px solid rgba(255,255,255,.25); background:#122269; display:block;
      object-fit:cover;
    }
    .name-row{ margin:0 0 6px 0; }
    .name{ font-weight:800; font-size:18px; }
    .nick{ font-weight:700; font-size:14px; }
    .meta{ margin-top:6px; font-size:10.5px; letter-spacing:.08em; text-transform:uppercase; }
    .meta-grid{ width:100%; }
    .meta-grid td{ padding:1px 0; }
    .meta .label{ opacity:.9; }
    .meta .right{ text-align:right; opacity:.95; }
    .addr{ margin-top:6px; font-size:11px; opacity:.95; word-break:break-word; }

    /* intro (ต่อด้วย skills) */
    .intro{
      background:var(--brand); color:var(--white);
      padding:10px 18px 12px; border-top:1px solid rgba(255,255,255,.25);
      white-space:pre-line;
    }

    /* ===== Body ===== */
    .body{ padding:16px 20px 24px; }
    .section{ margin-top:14px; }
    .title{ font-weight:700; color:#263041; font-size:12.5px; margin:0 0 6px 0; }
    .dash{ border:0; border-top:1px dashed var(--line); margin:0 0 8px 0; height:0; }

    .skill{
      color:var(--blue); font-weight:700; font-size:13.5px;
      line-height:1.55; white-space:pre-line;
    }
    .text{
      color:#1f2937; white-space:pre-line;
    }

    /* รูปหัวข้อ 1–4 */
    .section-image{
      display:block; margin:8px auto 2px; max-width:100%; height:auto; border-radius:6px;
    }

    /* ระยะสั้น ๆ ระหว่างกลุ่มบนหน้าแรก */
    .gap-xs{ height:8px; }
  </style>
</head>
<body>
@php
  // ใช้ path ที่คอนโทรลเลอร์ส่งมา (public_path) เพื่อความถูกต้องของ DomPDF
  $pp   = $paths['pp']   ?? null;
  $img1 = $paths['img1'] ?? null;
  $img2 = $paths['img2'] ?? null;
  $img3 = $paths['img3'] ?? null;
  $img4 = $paths['img4'] ?? null;
@endphp

<div class="wrap">

  <!-- ===== HEADER ===== -->
  <div class="header keep">
    <table class="head-table">
      <tr>
        <td style="width:150px;">
          <img src="{{ $pp ?: public_path('placeholder-160x200.png') }}" alt="Profile" class="avatar">
        </td>
        <td>
          <div class="name-row">
            <span class="name">{{ $cv->name ?? '-' }}&nbsp;&nbsp;{{ $cv->lastname ?? '-' }}</span>
            @if(!empty($cv->nickname))
              <span class="nick"> ({{ $cv->nickname }})</span>
            @endif
          </div>

          <div class="meta">
            <table class="meta-grid">
              <tr><td class="label">Education</td><td class="right">( major )</td></tr>
              <tr><td>{{ $cv->education ?? '-' }}</td><td class="right">{{ $cv->major ?? '-' }}</td></tr>

              <tr><td class="label">company</td><td class="right">&nbsp;</td></tr>
              <tr><td>{{ $cv->company ?? '-' }}</td><td class="right">&nbsp;</td></tr>

              <tr><td class="label">age</td><td class="right">&nbsp;</td></tr>
              <tr><td>{{ $cv->age ?? '-' }}</td><td class="right">&nbsp;</td></tr>
            </table>
          </div>

          @if(!empty($cv->address))
            <div class="addr">address&nbsp;&nbsp;{{ $cv->address }}</div>
          @endif
        </td>
      </tr>
    </table>
  </div>

  <!-- INTRO + SKILLS อยู่หน้าแรกติดกัน -->
  @if(!empty($cv->introduce))
    <div class="intro keep">{!! nl2br(e($cv->introduce)) !!}</div>
  @endif

  <div class="body">

    <!-- Programing Skills (ต่อท้าย intro) -->
    <div class="section keep" style="margin-top:10px;">
      <div class="title">Programing Skills</div>
      <hr class="dash">
      <div class="skill">{{ $cv->skill_programming ?? '' }}</div>
    </div>

    <div class="gap-xs"></div>

    <!-- General Skills (ยังอยู่บนหน้าแรกถ้าพื้นที่พอ) -->
    <div class="section keep" style="margin-top:10px;">
      <div class="title">General Skills</div>
      <hr class="dash">
      <div class="text">{{ $cv->general_skill ?? '' }}</div>
    </div>

    <!-- Activities -->
    <div class="section keep">
      <div class="title">Activities</div>
      <hr class="dash">
      <div class="text">{{ $cv->activity ?? '' }}</div>
    </div>

    <!-- Experience -->
    <div class="section keep">
      <div class="title">Experience</div>
      <hr class="dash">
      <div class="text">{{ $cv->experience ?? '' }}</div>
    </div>

    <!-- Section 1 -->
    @if(!empty($cv->section1_title) || $img1)
      <div class="section keep">
        <div class="title">{{ $cv->section1_title ?: 'Section 1' }}</div>
        <hr class="dash">
        @if($img1) <img src="{{ $img1 }}" class="section-image" alt="section1_image"> @endif
      </div>
    @endif

    <!-- Section 2 -->
    @if(!empty($cv->section2_title) || $img2)
      <div class="section keep">
        <div class="title">{{ $cv->section2_title ?: 'Section 2' }}</div>
        <hr class="dash">
        @if($img2) <img src="{{ $img2 }}" class="section-image" alt="section2_image"> @endif
      </div>
    @endif

    <!-- Section 3 -->
    @if(!empty($cv->section3_title) || $img3)
      <div class="section keep">
        <div class="title">{{ $cv->section3_title ?: 'Section 3' }}</div>
        <hr class="dash">
        @if($img3) <img src="{{ $img3 }}" class="section-image" alt="section3_image"> @endif
      </div>
    @endif

    <!-- Section 4 -->
    @if(!empty($cv->section4_title) || $img4)
      <div class="section keep">
        <div class="title">{{ $cv->section4_title ?: 'Section 4' }}</div>
        <hr class="dash">
        @if($img4) <img src="{{ $img4 }}" class="section-image" alt="section4_image"> @endif
      </div>
    @endif

  </div>
</div>
</body>
</html>
