<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OTP Verification</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg:#0b1220;        /* พื้นหลังหลัก */
      --panel:#0f172a;     /* การ์ดเข้ม */
      --border:rgba(255,255,255,.12);
      --text:#e5e7eb;      /* ตัวอักษรหลัก */
      --muted:#9aa4b2;     /* ตัวอักษรรอง */
      --brand:#2563eb;     /* ฟ้า */
      --brand2:#7c3aed;    /* ม่วง */
    }

    body{
      font-family:'Prompt', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      background:
        radial-gradient(1200px 520px at 10% -10%, rgba(124,58,237,.18), transparent),
        radial-gradient(1200px 520px at 110% 10%, rgba(37,99,235,.14), transparent),
        var(--bg);
      color:var(--text);
      min-height:100vh;
      display:flex; align-items:center;
    }

    .container{ max-width:800px; }

    /* Card มืดแบบ glass */
    .card{
      background: linear-gradient(180deg, var(--panel), rgba(15,23,42,.95));
      border:1px solid var(--border);
      border-radius:20px;
      box-shadow:0 30px 80px rgba(2,6,23,.55);
      overflow:hidden;
    }
    .card-body{ padding:2rem; }

    h2{ color:#fff; font-weight:800; }

    /* ฟอร์ม Dark */
    .form-label{ color:var(--muted); font-weight:600; }
    .form-control{
      border-radius:14px;
      padding:.9rem 1.15rem;
      background:#0b1220;
      color:var(--text);
      border:1px solid var(--border);
      box-shadow:none;
    }
    .form-control::placeholder{ color:#778296; }
    .form-control:focus{
      border-color:#c7d2fe;
      box-shadow:0 0 0 .2rem rgba(99,102,241,.18);
      background:#0b1220;
      color:var(--text);
    }

    /* ปุ่มหลัก ไล่เฉดฟ้า-ม่วง */
    .btn-custom{
      border-radius:14px;
      padding:.9rem 1.25rem;
      font-weight:700;
      letter-spacing:.2px;
      transition:transform .15s ease, box-shadow .15s ease, filter .15s ease, background .15s ease;
    }
    .btn-primary{
      background: linear-gradient(135deg, var(--brand), var(--brand2));
      border:none;
      color:#fff;
      box-shadow:0 14px 30px rgba(37,99,235,.28);
    }
    .btn-primary:hover{
      transform:translateY(-2px);
      filter:brightness(1.03);
      box-shadow:0 18px 36px rgba(37,99,235,.36);
    }

    /* ปุ่มส่ง OTP อีกครั้ง (outline ให้เข้มขึ้น) */
    .btn-outline-secondary{
      color:#fff;
      border:1px solid var(--border);
      border-radius:14px;
      padding:.7rem 1.15rem;
      background:transparent;
    }
    .btn-outline-secondary:hover{
      background:rgba(255,255,255,.06);
      border-color:rgba(255,255,255,.22);
      color:#fff;
    }

    /* ข้อความสถานะ */
    .text-success{ color:#34d399 !important; }
    .invalid-feedback{ color:#fca5a5; }
  </style>
</head>

<body>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h2 class="text-center mb-4">ยืนยันรหัส OTP</h2>

            <!--ส่งไป Route::post('/verify-otp')-->
            <form action="/verify-otp" method="POST">
              @csrf
              <div class="mb-4">
                <label for="otp" class="form-label">
                  กรุณากรอกหมายเลข OTP<br>(หมายเลข OTP ถูกส่งในอีเมลที่ทำการสมัคร)
                </label>
                <input type="text"
                       class="form-control @error('otp') is-invalid @enderror"
                       id="otp" name="otp" required
                       placeholder="เช่น 123456">
                @error('otp')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-custom btn-primary">ยืนยัน OTP</button>
              </div>
            </form>

            <!--ส่ง OTP ซ้ำ-->
            <form action="{{ route('otp.resend') }}" method="POST" class="mt-3 text-center">
              @csrf
              <button type="submit" class="btn btn-outline-secondary">ส่ง OTP อีกครั้ง</button>
            </form>

            <!-- แจ้งเตือน success -->
            @if(session('success'))
              <p class="text-success text-center mt-3" style="font-weight:600;">
                {{ session('success') }}
              </p>
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // เช็คการหลุดของเน็ต
    function checkOffline() {
      if (!navigator.onLine) {
        alert('คุณออฟไลน์อยู่ กรุณาตรวจสอบการเชื่อมต่ออินเทอร์เน็ต');
        window.location.href = "/offline";
      }
    }
    window.addEventListener('load', checkOffline);
    window.addEventListener('offline', checkOffline);
  </script>
</body>
</html>
