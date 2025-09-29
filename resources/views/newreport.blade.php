<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>เพิ่มข้อมูล Portfolio (CV)</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    :root{
      --bg:#0b1220;         /* พื้นหลังหลัก */
      --panel:#0f172a;      /* กล่อง/การ์ด */
      --ink:#e5e7eb;        /* ตัวอักษรหลัก */
      --muted:#9aa4b2;      /* ตัวอักษรรอง/placeholder */
      --border:rgba(255,255,255,.12);
      --hover:rgba(255,255,255,.06);
      --brand:#2563eb;      /* ฟ้า */
      --brand2:#7c3aed;     /* ม่วง */
    }

    body{
      font-family:'Prompt',sans-serif;
      color:var(--ink);
      background:
        radial-gradient(1200px 520px at 10% -10%, rgba(124,58,237,.18), transparent),
        radial-gradient(1200px 520px at 110% 10%, rgba(37,99,235,.14), transparent),
        var(--bg);
      min-height:100vh;
    }

    .container{ max-width: 980px; }

    .card{
      background: linear-gradient(180deg, var(--panel), rgba(15,23,42,.96));
      border:1px solid var(--border);
      border-radius:16px;
      box-shadow:0 18px 48px rgba(2,6,23,.55);
      overflow:hidden;
    }

    .card-body{ padding: 2rem; }

    h1{ font-weight:800; letter-spacing:.2px; }

    .form-control, .form-select{
      background: rgba(255,255,255,.03);
      color: var(--ink);
      border:1px solid var(--border);
      border-radius:14px;
      padding:.8rem 1rem;
    }
    .form-control::placeholder{ color: var(--muted); }
    .form-select option{ color:#0b1220; } /* เมนูดรอปดาวน์ */
    .form-control:focus, .form-select:focus{
      border-color: rgba(99,102,241,.55);
      box-shadow: 0 0 0 .2rem rgba(99,102,241,.25);
      background: rgba(255,255,255,.05);
    }

    .section-title{
      font-weight:700;
      margin-top:1.5rem;
      padding-top:1rem;
      border-top:1px dashed var(--border);
      color:#ffffff;
    }

    .hint{ font-size:.9rem; color:var(--muted); }

    .btn-custom{ border-radius:14px; padding:.85rem 1.2rem; font-weight:700; letter-spacing:.2px; }
    .btn-primary{
      background: linear-gradient(135deg, var(--brand), var(--brand2));
      border:none; color:#fff;
      box-shadow:0 12px 30px rgba(37,99,235,.28);
      transition: transform .15s ease, filter .15s ease;
    }
    .btn-primary:hover{ transform: translateY(-2px); filter:brightness(1.06); }

    .btn-secondary{
      background: rgba(255,255,255,.06);
      color: var(--ink);
      border:1px solid var(--border);
    }
    .btn-secondary:hover{ background: var(--hover); }

    .text-muted{ color:var(--muted) !important; }
    /* === Force headings & labels to white on dark theme === */
h1, h2, h3, h4, h5, h6,
.section-title,
.form-label,
.form-check-label,
label {
  color: #fff !important;
}

/* ถ้าอยากให้ข้อความช่วยอธิบายสว่างขึ้นนิดหน่อยด้วย */
.hint, .text-muted {
  color: rgba(255,255,255,.75) !important;
}
/* === Dark form text overrides (เฉพาะในฟอร์ม newreport/cv) === */
#cvForm .form-control,
#cvForm .form-select,
#cvForm textarea,
#cvForm input[type="text"],
#cvForm input[type="email"],
#cvForm input[type="password"],
#cvForm input[type="number"],
#cvForm input[type="date"],
#cvForm input[type="file"] {
  background: rgba(255,255,255,.06);
  color: #fff !important;             /* ตัวอักษรขาว */
  border: 1px solid rgba(255,255,255,.18);
  border-radius: 14px;
}

/* Placeholder ให้สว่างขึ้น */
#cvForm .form-control::placeholder,
#cvForm textarea::placeholder {
  color: rgba(255,255,255,.6);
}

/* ตอนโฟกัส: ขอบและเงาแบบโทนม่วง/ฟ้า */
#cvForm .form-control:focus,
#cvForm .form-select:focus,
#cvForm textarea:focus {
  border-color: rgba(99,102,241,.6);
  box-shadow: 0 0 0 .2rem rgba(99,102,241,.25);
  background: rgba(255,255,255,.08);
  color: #fff;
}

/* Label ให้เป็นสีขาวด้วย */
#cvForm .form-label,
#cvForm label {
  color: #fff !important;
}

/* แก้สีตอน Chrome Autofill (พื้นเหลือง) */
#cvForm input:-webkit-autofill,
#cvForm textarea:-webkit-autofill,
#cvForm select:-webkit-autofill {
  -webkit-text-fill-color: #fff !important;
  caret-color: #fff;
  transition: background-color 5000s ease-in-out 0s;
  /* ทับพื้นหลัง autofill ให้กลืนกับธีม */
  -webkit-box-shadow: 0 0 0 1000px rgba(255,255,255,.06) inset !important;
  box-shadow: 0 0 0 1000px rgba(255,255,255,.06) inset !important;
}

/* ปุ่มเลือก (checkbox/radio) โทนมืด */
#cvForm .form-check-input {
  background-color: rgba(255,255,255,.06);
  border: 1px solid rgba(255,255,255,.3);
}
#cvForm .form-check-input:checked {
  background-color: #2563eb;
  border-color: #2563eb;
}



  </style>
</head>
<body>

    @if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($errors->any())
  <div class="alert alert-danger">
    <strong>บันทึกไม่สำเร็จ</strong>
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

  <div class="container my-5">
    <div class="card">
      <div class="card-body">
        <h1 class="text-center mb-4">เพิ่มข้อมูล Portfolio (CV)</h1>

        {{-- ส่งไปยัง reports.store ตามที่กำหนด --}}
        <form id="cvForm" action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row g-3">
            <div class="col-md-4">
              <label for="name" class="form-label">ชื่อ</label>
              <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label for="lastname" class="form-label">นามสกุล</label>
              <input type="text" name="lastname" id="lastname" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label for="nickname" class="form-label">ชื่อเล่น</label>
              <input type="text" name="nickname" id="nickname" class="form-control">
            </div>

            <div class="col-md-3">
              <label for="age" class="form-label">อายุ</label>
              <input type="text" name="age" id="age" class="form-control">
            </div>
            <div class="col-md-9">
              <label for="address" class="form-label">ที่อยู่</label>
              <input type="text" name="address" id="address" class="form-control">
            </div>

            <div class="col-md-6">
              <label for="company" class="form-label">ตำแหน่ง</label>
              <input type="text" name="company" id="company" class="form-control">
            </div>
            <div class="col-md-3">
              <label for="education" class="form-label">การศึกษา</label>
              <input type="text" name="education" id="education" class="form-control">
            </div>
            <div class="col-md-3">
              <label for="major" class="form-label">สาขา/เอก</label>
              <input type="text" name="major" id="major" class="form-control">
            </div>

            <div class="col-12">
              <label for="introduce" class="form-label">แนะนำตัว (Introduce)</label>
              <textarea name="introduce" id="introduce" rows="3" class="form-control" placeholder="สรุปตัวเองสั้น ๆ จุดเด่น ประสบการณ์ย่อ ๆ"></textarea>
            </div>

            <div class="col-12">
              <label for="skill_programming" class="form-label">ทักษะด้าน Programming</label>
              <textarea name="skill_programming" id="skill_programming" rows="3" class="form-control" placeholder="ภาษา/เฟรมเวิร์ก/เครื่องมือ ฯลฯ"></textarea>
            </div>

            <div class="col-12">
              <label for="general_skill" class="form-label">ทักษะทั่วไป (Soft skills)</label>
              <textarea name="general_skill" id="general_skill" rows="3" class="form-control" placeholder="การสื่อสาร การทำงานทีม ภาวะผู้นำ เป็นต้น"></textarea>
            </div>


            <div class="col-12">
              <label for="activity" class="form-label">กิจกรรม/ผลงานอื่น ๆ</label>
              <textarea name="activity" id="activity" rows="3" class="form-control"></textarea>
            </div>


            <div class="col-12">
              <label for="experience" class="form-label">ประสบการณ์ทำงาน/โปรเจค</label>
              <textarea name="experience" id="experience" rows="4" class="form-control" placeholder="สรุปแบบ bullet หรือย่อหน้า"></textarea>
            </div>

            

            <div class="col-md-6">
              <label for="profile_picture" class="form-label">รูปโปรไฟล์</label>
              <input type="file" name="profile_picture" id="profile_picture" class="form-control" accept="image/*">
              <div class="hint mt-1">รองรับ .jpg .jpeg .png .gif .heic .heif ขนาดไม่เกิน 5MB</div>
            </div>
          </div>

          {{-- ชุดหัวข้อ/ภาพ 1–4 --}}
          <h5 class="section-title">หัวข้อ & รูปภาพเพิ่มเติม</h5>

          <div class="row g-3 mt-1">
            <div class="col-md-6">
              <label for="section1_title" class="form-label">หัวข้อที่ 1</label>
              <input type="text" name="section1_title" id="section1_title" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="section1_image" class="form-label">ภาพที่ 1</label>
              <input type="file" name="section1_image" id="section1_image" class="form-control" accept="image/*">
            </div>

            <div class="col-md-6">
              <label for="section2_title" class="form-label">หัวข้อที่ 2</label>
              <input type="text" name="section2_title" id="section2_title" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="section2_image" class="form-label">ภาพที่ 2</label>
              <input type="file" name="section2_image" id="section2_image" class="form-control" accept="image/*">
            </div>

            <div class="col-md-6">
              <label for="section3_title" class="form-label">หัวข้อที่ 3</label>
              <input type="text" name="section3_title" id="section3_title" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="section3_image" class="form-label">ภาพที่ 3</label>
              <input type="file" name="section3_image" id="section3_image" class="form-control" accept="image/*">
            </div>

            <div class="col-md-6">
              <label for="section4_title" class="form-label">หัวข้อที่ 4</label>
              <input type="text" name="section4_title" id="section4_title" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="section4_image" class="form-label">ภาพที่ 4</label>
              <input type="file" name="section4_image" id="section4_image" class="form-control" accept="image/*">
            </div>
          </div>

          <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-custom btn-primary">บันทึก CV</button>
            <a href="{{ url('/user-reports') }}" class="btn btn-custom btn-secondary">ย้อนกลับ</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Bootstrap --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  {{-- ตรวจไฟล์ภาพ: ชนิด + ขนาดไม่เกิน 5MB --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const allowed = ['image/jpeg','image/png','image/jpg','image/gif','image/heic','image/heif'];
      const maxMB = 5;

      document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', () => {
          for (const file of input.files) {
            if (!allowed.includes(file.type)) {
              alert(`ไฟล์ ${file.name} ไม่ใช่ไฟล์ภาพที่รองรับ`);
              input.value = ""; return;
            }
            if ((file.size / (1024*1024)) > maxMB) {
              alert(`ไฟล์ ${file.name} มีขนาดเกิน ${maxMB}MB`);
              input.value = ""; return;
            }
          }
        });
      });
    });
  </script>
</body>
</html>
