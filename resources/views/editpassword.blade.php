<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>แก้ไขรหัสผ่าน</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg:#0b1220;        /* พื้นหลังหลัก */
      --panel:#0f172a;     /* สีการ์ด */
      --border:rgba(255,255,255,.12);
      --text:#e5e7eb;      /* ตัวอักษรหลัก */
      --muted:#9aa4b2;     /* ตัวอักษรรอง */
      --brand:#2563eb;     /* ฟ้า */
      --brand2:#7c3aed;    /* ม่วง */
      --danger:#ef4444;
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

    /* การ์ดมืดแบบ glass */
    .card{
      background: linear-gradient(180deg, var(--panel), rgba(15,23,42,.95));
      border:1px solid var(--border);
      border-radius:20px;
      box-shadow:0 30px 80px rgba(2,6,23,.55);
      overflow:hidden;
    }
    .card-body{ padding:2rem; }

    h2{ color:#fff; font-weight:800; }

    /* ฟอร์มโทนมืด */
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
      transition:transform .15s ease, box-shadow .15s ease, filter .15s ease;
    }
    .btn-primary{
      background: linear-gradient(135deg, var(--brand), var(--brand2));
      border:none; color:#fff;
      box-shadow:0 14px 30px rgba(37,99,235,.28);
    }
    .btn-primary:hover{
      transform:translateY(-2px);
      filter:brightness(1.03);
      box-shadow:0 18px 36px rgba(37,99,235,.36);
    }

    /* ปุ่มรองโทนมืด */
    .btn-secondary{
      background:transparent; color:#fff; border:1px solid var(--border);
      border-radius:14px; padding:.9rem 1.25rem; font-weight:700;
    }
    .btn-secondary:hover{
      background:rgba(255,255,255,.06);
      border-color:rgba(255,255,255,.22);
      color:#fff;
    }

    /* โมดัลธีมมืด */
    .modal-content{
      background: linear-gradient(180deg, var(--panel), rgba(15,23,42,.95));
      color:var(--text);
      border-radius:18px;
      border:1px solid var(--border);
      box-shadow:0 24px 64px rgba(2,6,23,.6);
    }
    .modal-header{
      background:transparent;
      border-bottom:1px solid rgba(255,255,255,.06);
      border-radius:18px 18px 0 0;
    }
    .modal-footer{ border-top:1px solid rgba(255,255,255,.06); }
    .btn-close{ filter: invert(1); } /* ให้ X มองเห็นบนพื้นมืด */

    /* ข้อความแจ้งเตือน */
    .invalid-feedback{ color:#fca5a5; }
  </style>
</head>
<body>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h2 class="text-center mb-4">แก้ไขรหัสผ่าน</h2>

            <!--ส่งไป Route::put('updatepassword')-->
            <form id="changePasswordForm" action="{{ route('updatepassword') }}" method="POST">
              @csrf
              @method('PUT')

              <div class="mb-4">
                <label for="current_password" class="form-label">รหัสผ่านปัจจุบัน</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
              </div>

              <div class="mb-4">
                <label for="new_password" class="form-label">รหัสผ่านใหม่</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
              </div>

              <div class="mb-4">
                <label for="new_password_confirmation" class="form-label">ยืนยันรหัสผ่านใหม่</label>
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                <div id="password-match-message" class="form-text mt-2"></div>
              </div>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-custom btn-primary">บันทึกการเปลี่ยนแปลง</button>
                <a href="/profile" class="btn btn-custom btn-secondary">ยกเลิก</a>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- โมดัลแจ้งเตือน -->
  <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="errorModalLabel">แจ้งเตือน</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- จุดข้อความ -->
        <div class="modal-body" id="errorModalBody"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
        var newPassword = document.getElementById('new_password').value;
        var confirmPassword = document.getElementById('new_password_confirmation').value;
        var errorMessage = '';

        if (newPassword.length < 6) {
          errorMessage = 'รหัสผ่านใหม่ต้องมีความยาวอย่างน้อย 6 ตัวอักษร';
        } else if (newPassword !== confirmPassword) {
          errorMessage = 'รหัสผ่านใหม่และการยืนยันรหัสผ่านไม่ตรงกัน';
        }

        if (errorMessage) {
          event.preventDefault();
          var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
          document.getElementById('errorModalBody').textContent = errorMessage;
          errorModal.show();
        }
      });
    });
  </script>

  <!-- แสดง return back จาก controller -->
  @if(session('error'))
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
      document.getElementById('errorModalBody').textContent = {!! json_encode(session('error')) !!};
      errorModal.show();
    });
  </script>
  @endif

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
