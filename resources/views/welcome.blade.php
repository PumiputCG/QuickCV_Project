<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--รองรับขนาดหน้าจอในมือถือ-->
    <title>FraudCheck</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet"> 
    <style>
  /* ====== Dark Theme Tokens ====== */
  :root{
    --bg: #0b1220;             /* พื้นหลังหลัก (เข้ม) */
    --bg-2: #0f172a;           /* เข้มอีกเฉด */
    --panel: rgba(255,255,255,.06);
    --border: rgba(255,255,255,.12);
    --text: #e5e7eb;
    --text-muted: #9aa4b2;

    --brand: #2563eb;          /* ฟ้า */
    --brand-2: #7c3aed;        /* ม่วง */
    --accent: #10b981;         /* เขียวสว่าง (สำรอง) */
    --warning: #f59e0b;        /* อำพัน สำหรับปุ่ม search */
  }

  /* ====== Base ====== */
  body{
    font-family: 'Prompt', system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial, sans-serif;
    background:
      radial-gradient(1200px 600px at 10% -10%, rgba(124,58,237,.18), transparent),
      radial-gradient(1200px 600px at 110% 10%, rgba(37,99,235,.14), transparent),
      var(--bg);
    color: var(--text);
  }
  .container{ max-width: 880px; }

  /* ====== Hero Card (แทนของเดิมให้ดูเป็น glass dark) ====== */
  .hero{
    background: linear-gradient(135deg, rgba(124,58,237,.18), rgba(37,99,235,.14));
    color: var(--text);
    padding: 3.5rem 1.75rem;
    border-radius: 20px;
    border: 1px solid var(--border);
    box-shadow: 0 30px 80px rgba(2,6,23,.45);
    backdrop-filter: blur(10px);
  }
  .hero h1{
    font-weight: 800;
    font-size: clamp(2rem, 4vw, 3rem);
    margin-bottom: 1rem;
    letter-spacing: .2px;
  }
  .hero .subtitle{ color: var(--text-muted); }

  /* ====== Buttons ====== */
  .btn-custom{
    border-radius: 14px;
    padding: .9rem 1.25rem;
    font-weight: 700;
    letter-spacing: .2px;
    transition: transform .15s ease, box-shadow .15s ease, filter .15s ease, background .15s ease, border-color .15s ease;
  }
  .btn-custom:hover{
    transform: translateY(-2px);
    box-shadow: 0 18px 36px rgba(37,99,235,.28);
    filter: brightness(1.03);
  }

  /* ปุ่ม Login: ไล่เฉดฟ้า-ม่วง */
  .btn-login{
    background: linear-gradient(135deg, var(--brand), var(--brand-2));
    color: #fff;
    border: none;
  }
  .btn-login:hover{
    box-shadow: 0 16px 34px rgba(124,58,237,.35);
  }

  /* ปุ่ม Register: โทนมืดแบบขอบใส */
  .btn-register{
    background: transparent;
    color: #fff;
    border: 1px solid var(--border);
    box-shadow: 0 10px 22px rgba(2,6,23,.35);
  }
  .btn-register:hover{
    background: rgba(255,255,255,.06);
    border-color: rgba(255,255,255,.22);
  }

  /* ปุ่ม Search (ถ้ายังใช้) : อำพันบนพื้นมืด */
  .btn-search{
    background-color: var(--warning);
    color: #1f2937;
    border: none;
  }
  .btn-search:hover{
    background-color: #fbbf24;
    color: #111827;
    box-shadow: 0 14px 28px rgba(245,158,11,.25);
  }

  .text-muted-link{
    color: var(--text-muted);
    text-decoration: none;
    transition: color .15s ease, text-decoration .15s ease;
  }
  .text-muted-link:hover{
    color: #fff;
    text-decoration: underline;
  }

  /* ====== Modal (Dark) ====== */
  .modal-content{
    background: linear-gradient(180deg, var(--bg-2), rgba(15,23,42,.95));
    color: var(--text);
    border-radius: 18px;
    border: 1px solid var(--border);
    box-shadow: 0 24px 64px rgba(2,6,23,.6);
  }
  .modal-header{
    background: transparent;
    border-bottom: 1px solid rgba(255,255,255,.06);
    border-radius: 18px 18px 0 0;
  }
  .modal-footer{
    border-top: 1px solid rgba(255,255,255,.06);
  }
  .modal-title{ font-weight: 800; }

  /* ====== Form Controls (Dark) ====== */
  .form-label{ color: var(--text-muted); font-weight: 600; }
  .form-control{
    border-radius: 12px;
    padding: .8rem 1rem;
    background: #0b1220;
    color: var(--text);
    border: 1px solid rgba(255,255,255,.12);
    box-shadow: none;
  }
  .form-control::placeholder{ color: #6b7280; }
  .form-control:focus{
    border-color: #c7d2fe;
    box-shadow: 0 0 0 .2rem rgba(99,102,241,.18);
    background: #0b1220;
    color: var(--text);
  }
  .text-white-glow {
  color: #fff !important;
  text-shadow: 0 2px 24px rgba(255,255,255,.15);
}
  
</style>

</head>
<body>
             <!--แจ้งเตือนล็อคอินซ้อนกัน-->
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

    @auth
        <div style="position: absolute; top: 5px; right: 20px; z-index: 999;">
            <a href="{{ route('profile') }}" class="btn btn-outline-primary">โปรไฟล์ของฉัน</a>
        </div>
    @endauth
    
    <div class="container my-5">
        <div class="hero text-center">
            <h1 class="mb-4">QuickCV</h1>
           <div class="subtitle text-white-50 mb-4">Develop by Pumiput Chaichat</div>

            <div class="d-grid gap-3 col-lg-6 mx-auto">
               
                <!--กำหนดจุด popup ล็อคอิน-->
                <a href="#" class="btn btn-custom btn-login btn-lg" data-bs-toggle="modal" data-bs-target="#loginModal">เข้าสู่ระบบ</a>
                <p class="mt-3">
                    <!--กำหนดจุด popup สมัครสมาชิก-->
                    <a href="#" class="btn btn-custom btn-register btn-lg" data-bs-toggle="modal" data-bs-target="#registerModal">สมัครบัญชีผู้ใช้งานใหม่</a>
                    
                </p>
               
            </div>
        </div>
    </div>

    <!-- กล่อง Modal ล็อคอิน-->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> <!--จัด modal กึ่งกลาง-->
            <div class="modal-content"> 
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">เข้าสู่ระบบ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> <!--แถบปิด-->
                </div>
                <!--ระบบล็อคอิน-->
                <div class="modal-body">
                    <!--ส่งไป Route::post('/profile')-->
                    <form action="/profile" method="POST">
                        @csrf <!--csrf ป้องกัน request จากเว็บอื่น-->
                        <div class="mb-3">
                            <label for="username" class="form-label">ชื่อผู้ใช้</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">รหัสผ่าน</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-custom btn-search w-100">เข้าสู่ระบบ</button>
                        
                    </form>
                    
                </div>
                
            </div>
        </div>
    </div>
<!-- หัวข้อเหนือรูป -->
<!-- บล็อกอยู่กึ่งกลางทั้งก้อน -->
<div class="d-flex justify-content-center">
  <!-- กล่องความกว้างเท่ารูป ชิดซ้ายข้างใน -->
  <div class="text-start" style="max-width: 820px; width: 100%;">
    <div class="fs-2 mb-2">Example :</div>

    <a href="https://ibb.co/jkW7qn6Z" target="_blank" rel="noopener">
      <img
        class="sample-img mb-4 w-100 d-block"
        src="https://i.ibb.co/chCzR4gX/1.jpg"
        alt="ตัวอย่าง Portfolio"
      >
    </a>
    <a href="https://ibb.co/Q3jjp5fN" target="_blank" rel="noopener">
      <img
        class="sample-img mb-4 w-100 d-block"
        src="https://i.ibb.co/TxqqYCk8/5.jpg"
        alt="ตัวอย่าง Portfolio"
      >
    </a>
    <a href="https://ibb.co/KzK5YGBY" target="_blank" rel="noopener">
      <img
        class="sample-img mb-4 w-100 d-block"
        src="https://i.ibb.co/gF4rG7QG/3.jpg"
        alt="ตัวอย่าง Portfolio"
      >
    </a>
    <a href="https://ibb.co/jYYX3x5" target="_blank" rel="noopener">
      <img
        class="sample-img mb-4 w-100 d-block"
        src="https://i.ibb.co/zggvPL5/4.jpg"
        alt="ตัวอย่าง Portfolio"
      >
    </a>
  </div>
</div>


    <!-- กล่อง Modal สมัครสมาชิก-->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">สมัครบัญชีผู้ใช้งานใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> <!--แถบปิด-->
                </div>
                <!--ระบบสมัครสมาชิก-->
                <div class="modal-body">
                     <!--ส่งไป Route::post('/register')-->
                    <form action="/register" method="POST" id="registerForm">
                        @csrf <!--csrf ป้องกัน request จากเว็บอื่น-->
                        <div class="mb-3">
                            <label for="newUsername" class="form-label">ชื่อผู้ใช้ (ห้ามซ้ำ)</label>
                            <input type="text" class="form-control" id="newUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="newEmail" class="form-label">อีเมล (ห้ามซ้ำ)</label>
                            <input type="email" class="form-control" id="newEmail" name="email" required>
                            <div id="emailHelp" class="form-text text-danger"></div> <!-- จุดแสดงข้อความเล็ก -->
                            
                        </div>

                        <div>
                            <p>หมายเหตุ* อีเมลที่สามารถใช้งานได้ ได้แก่</p>
                            <p style="color : red">@gmail.com, @yahoo.com, @icloud.com</p>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">รหัสผ่าน (กรอกรหัสผ่าน 6 ตัวขึ้นไป)</label>
                            <input type="password" class="form-control" id="newPassword" name="password" required>
                        </div>
                        <div id="passwordHelp" class="form-text text-danger"></div> <!--กำหนดจุดแจ้งเตือน-->
                        <button type="submit" class="btn btn-custom btn-search w-100">สมัครบัญชี</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- กล่อง modal แจ้งเตือน Error -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- ตำแหน่งข้อความ Error (errorModalBody ตัวแปรแสดงแจ้งเตือน) -->
                <div class="modal-body" id="errorModalBody"> 
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        //แจ้งเตือน สมัครสมาชิก, ตรวจสอบเงื่อนไข
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            var password = document.getElementById('newPassword').value;
            var email = document.getElementById('newEmail').value;
            var passwordHelp = document.getElementById('passwordHelp'); //รับค่าแจ้งเตือนเล็กๆ
            const emailHelp = document.getElementById('emailHelp'); //รับค่าแจ้งเตือนเล็กๆ
            // ตรวจสอบรหัสผ่าน
            if (password.length < 6) {
                event.preventDefault(); //หยุดส่งฟอร์ม เพื่อตรวจสอบเงื่อนไขก่อน
                passwordHelp.innerHTML = 'รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร'; //แจ้งเตือนเล็กๆ
                showErrorModal('รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร'); //ส่งไปแสดงฟังก์ชันล่าง
                return; //หยุด ไม่ให้ทำเงื่อนไขต่อไป
            }

            // ตรวจสอบอีเมล
            const allowedDomains = ['gmail.com', 'yahoo.com', 'icloud.com', 'dome.tu.ac.th'];
            const emailDomain = email.split('@')[1]; //ใช้หลัง @ เช่น gmail.com        
            //ตรวจสอบ ถ้าไม่มี @ หรือ ไม่ใช่อีเมลที่ระบุ ให้แจ้งเตือน
            if (!emailDomain || !allowedDomains.includes(emailDomain)) {
                event.preventDefault(); //หยุดส่งฟอร์ม เพื่อตรวจสอบเงื่อนไขก่อน
                emailHelp.innerHTML = 'กรุณาใช้อีเมลที่ลงท้ายด้วย @gmail.com, @yahoo.com, @icloud.com หรือ @dome.tu.ac.th'; //แจ้งเตือนเล็กๆ
                showErrorModal('ผู้ใช้งานกรอกอีเมลไม่ตรงเงื่อนไข กรุณาใช้อีเมลที่ลงท้ายด้วย @gmail.com, @yahoo.com, @icloud.com หรือ @dome.tu.ac.th'); //ส่งไปแสดงฟังก์ชันล่าง
                return; //หยุด ไม่ให้ทำเงื่อนไขต่อไป
            }
            
            passwordHelp.innerHTML = ''; //แสดง error เสร็จสิ้น ให้ล้างข้อความ
        });

        //นำข้อความมาแสดงเป็นป้าย (showErrorModal)
        function showErrorModal(message) { 
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal')); //ตำแหน่งกล่องข้อความ

            document.getElementById('errorModalBody').innerHTML = message; //จุดที่แสดงกล่องแจ้งเตือน
            errorModal.show(); //แสดง
   
        }

        //แจ้งเตือน ล็อคอิน
        //นำตัวแปรจาก controller(return back) มาใช้
        @if(session('loginError'))
            showErrorModal('การเข้าสู่ระบบผิดพลาด ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
        @endif

        //แจ้งเตือน สมัครสมาชิก
        //แสดง modal จาก controller(return Error)
        @if($errors->any())
        //ฟังก์ชันแปล message จาก อังกฤษเป็นไทย (ตั้งค่า)
        function replaceErrorMessage(message) { 
            if (message.includes('username')) {
                return 'ชื่อผู้ใช้ได้ถูกนำไปใช้แล้ว';
            } else if (message.includes('email')) {
                return 'อีเมล์นี้ได้ถูกนำไปใช้แล้ว';
            } 
            return message;
        }

        //รับค่า error จาก controller มาวนลูป (กรณี id กับ email ผิดพลาดทั้งคู่)
        var errorMessages = [
            @foreach ($errors->all() as $error)
                '{{ $error }}', //ดึงข้อมูลจาก 'message' ใน controller
            @endforeach
        ];

        //ใช้ฟังก์ชันเปลี่ยน error เป็นภาษาไทย (ใช้งาน)
        var formattedErrorMessages = errorMessages.map(function(message) {
            return replaceErrorMessage(message); //ใช้ฟังก์ชันแปล
        });

        //นำ message ไทย มารวมกัน (เว้รบรรทัดด้วย <br>)
        var errorMessage = formattedErrorMessages.join('<br>');
        showErrorModal(errorMessage); //แสดง
        @endif
    </script>
    
</body>
</html>