<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP for Email Verification</title>
</head>
<body>
    <!-- ใช้ส่งรหัส OTP ไปยังอีเมลผู้ใช้งาน -->
    <h1>Your OTP for Email Verification</h1>
    <p>Your OTP is: <strong>{{ $otp }}</strong></p> <!-- แสดงรหัสสุ่ม 6 ตัว จาก Controller -->
    <p>This OTP will expire in 15 minutes.</p>

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



