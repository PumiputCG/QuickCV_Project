<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>โปรไฟล์ | QuickCV</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      --bg:#0b1220; --panel:#0f172a; --border:rgba(255,255,255,.12);
      --text:#e5e7eb; --muted:#9aa4b2;
      --brand:#2563eb; --brand2:#7c3aed;
    }
    body{
      background:
        radial-gradient(1100px 520px at 10% -10%, rgba(124,58,237,.18), transparent),
        radial-gradient(1100px 520px at 110% 10%, rgba(37,99,235,.14), transparent),
        var(--bg);
      color:var(--text);
      min-height:100vh;
      display:grid; place-items:center;
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }
    .card-dark{
      width:100%; max-width:780px;
      background: linear-gradient(180deg, var(--panel), rgba(15,23,42,.92));
      border:1px solid var(--border);
      border-radius:20px;
      padding:2rem 1.5rem;
      box-shadow:0 30px 80px rgba(2,6,23,.55);
      backdrop-filter: blur(8px);
    }
    .avatar{
      width:128px; height:128px; object-fit:cover;
      border-radius:16px; border:1px solid var(--border);
    }
    .username{ font-weight:800; margin:1rem 0 .25rem; }
    .email{ color:var(--muted); margin-bottom:1.5rem; }

    .btn-cta{
      border:none; color:#fff;
      background: linear-gradient(135deg, var(--brand), var(--brand2));
      border-radius:14px; padding:.9rem 1.1rem; font-weight:700;
      box-shadow:0 14px 30px rgba(37,99,235,.28);
      transition:transform .15s ease, box-shadow .15s ease, filter .15s ease;
    }
    .btn-cta:hover{ transform:translateY(-2px); filter:brightness(1.03); box-shadow:0 18px 36px rgba(37,99,235,.36); }

    .btn-outline-ink{
      background:transparent; color:#fff; border:1px solid var(--border);
      border-radius:14px; padding:.9rem 1.1rem; font-weight:700;
      transition:background .15s ease, transform .15s ease;
    }
    .btn-outline-ink:hover{ background:rgba(255,255,255,.06); transform:translateY(-2px); }

    .btn-danger-ink{
      background:#ef4444; color:#fff; border:none;
      border-radius:14px; padding:.9rem 1.1rem; font-weight:700;
      box-shadow:0 12px 26px rgba(239,68,68,.25);
      transition:transform .15s ease, box-shadow .15s ease, filter .15s ease;
    }
    .btn-danger-ink:hover{ transform:translateY(-2px); filter:brightness(1.03); box-shadow:0 16px 32px rgba(239,68,68,.33); }
  /* เดิม 128px -> เพิ่มเป็น 160px หรือ 180px */
.avatar{
  width: 320px;
  height: 320px;
  object-fit: cover; /* เผื่อยังไม่ได้ใส่ */
  border-radius: 16px;
}

  
  </style>
</head>
<body>

  <div class="card-dark text-center">
    <!-- 1) ภาพโปรไฟล์ -->
    <img
  class="avatar mb-2"
  src="{{ Auth::user()->profile_picture ? asset('storage/profile_pictures/'.Auth::user()->profile_picture) : 'https://via.placeholder.com/160x160?text=Avatar' }}"
  alt="Profile Picture">

    <!-- 2) ชื่อผู้ใช้งาน -->
    <h2 class="username">{{ Auth::user()->username }}</h2>

    <!-- 3) อีเมล -->
    <div class="email">{{ Auth::user()->email }}</div>

    <!-- ปุ่มต่าง ๆ -->
    <div class="d-grid gap-3 col-12 col-md-8 mx-auto mt-3">
      <!-- 4) เพิ่ม CV -->
      <a href="{{ route('user.reports') }}" class="btn btn-cta w-100">เพิ่ม CV</a>

      <!-- 5) แก้ไขข้อมูลส่วนตัว -->
      <a href="{{ url('/editprofile') }}" class="btn btn-outline-ink w-100">แก้ไขข้อมูลส่วนตัว</a>

      <!-- 6) เปลี่ยนรหัสผ่าน -->
      <a href="{{ route('editpassword') }}" class="btn btn-outline-ink w-100">เปลี่ยนรหัสผ่าน</a>

      <!-- 7) Log out -->
    <a href="/logout" class="btn btn-custom btn-danger">ออกจากระบบ</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
