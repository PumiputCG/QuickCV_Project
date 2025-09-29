<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Curriculum Vitae (CV)</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg:#0b1220; --panel:#0f172a; --ink:#e5e7eb; --muted:#9aa4b2;
      --border:rgba(255,255,255,.12); --brand:#2563eb; --brand2:#7c3aed; --hover:rgba(255,255,255,.06);
    }
    body{
      font-family:'Prompt', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      background:
        radial-gradient(1200px 520px at 10% -10%, rgba(124,58,237,.18), transparent),
        radial-gradient(1200px 520px at 110% 10%, rgba(37,99,235,.14), transparent),
        var(--bg);
      color:var(--ink); min-height:100vh; padding-bottom:32px;
    }
    .container{ max-width:1100px; }

    .hero{
      background: linear-gradient(135deg, rgba(37,99,235,.14), rgba(124,58,237,.14)), var(--panel);
      color:#fff; padding:2rem 1rem; border-radius:14px; border:1px solid var(--border);
      box-shadow:0 18px 48px rgba(2,6,23,.55); margin:2rem 0 1.25rem;
    }
    .hero h1{ margin:0; font-weight:800; letter-spacing:.2px; }

    .btn-custom{ border-radius:12px; padding:.7rem 1rem; font-weight:700; letter-spacing:.2px;
      transition: transform .15s ease, box-shadow .15s ease, filter .15s ease; }
    .btn-main{
      background: linear-gradient(135deg, var(--brand), var(--brand2)); color:#fff; border:none;
      box-shadow:0 14px 30px rgba(37,99,235,.28);
    }
    .btn-main:hover{ transform:translateY(-2px); filter:brightness(1.05); }

    /* --- กล่องตารางแบบพื้นขาว ตัวหนังสือดำ --- */
    .card{
      background: transparent; border:none; box-shadow:none;
    }
    .table-wrap{
      background:#ffffff; border-radius:14px; box-shadow:0 12px 30px rgba(2,6,23,.25);
      overflow:hidden; border:1px solid #e5e7eb;
    }
    .table{ color:#000; background:#fff; margin-bottom:0; }
    .table thead th{
      color:#000; background:#f1f5f9; border-bottom:1px solid #e5e7eb; font-weight:700;
    }
    .table tbody td{
      color:#000; background:#fff; border-top:1px solid #eef2f7;
    }
    .table-hover tbody tr:hover{ background:#f8fafc; }

    .btn-secondary-custom{
    background: linear-gradient(180deg, #4b5563, #374151); /* เทาเข้มไล่เฉด */
    color: #ffffff;                                       /* ตัวหนังสือขาว */
    border: 1px solid #475569;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(2,6,23,.35);
    transition: transform .15s ease, filter .15s ease, box-shadow .15s ease;
  }
  .btn-secondary-custom:hover{
    background: linear-gradient(180deg, #606a78, #4b5563); /* สว่างขึ้นเล็กน้อยตอนโฮเวอร์ */
    transform: translateY(-1px);
    box-shadow: 0 12px 26px rgba(2,6,23,.45);
  }
  .btn-secondary-custom:focus{
    outline: none;
    box-shadow:
      0 0 0 4px rgba(99,102,241,.25),  /* วงโฟกัสอ่านง่าย */
      0 12px 26px rgba(2,6,23,.45);
  }
  .btn-secondary-custom:active{
    transform: translateY(0);
    filter: brightness(0.98);
  }
  </style>
</head>
<body>

  <div class="container">
    <div class="hero text-center">
      <h1>Curriculum Vitae (CV)</h1>
    </div>

    <div class="mb-3 text-center">
      <a href="/newreport" class="btn btn-custom btn-main">+ เพิ่ม CV</a>
    </div>

    <div class="card">
      <div class="table-wrap">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th style="width:120px;">หมายเลข</th>
                <th>ชื่อ-นามสกุล</th>
                <th>บริษัท</th>
                <th style="width:180px;">การดำเนินการ</th>
              </tr>
            </thead>
            <tbody>
              @forelse($cvs as $cv)
                <tr>
                  <td>{{ $cv->id }}</td>
                  <td>{{ $cv->name }} {{ $cv->lastname }}</td>
                  <td>{{ $cv->company ?? '-' }}</td>
                  <td>
                    <!-- ปุ่มสีเขียวตามที่ขอ -->
                    <a href="{{ url('/cv/'.$cv->id) }}" class="btn btn-sm btn-success">ดู CV</a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-muted py-4">ยังไม่มีข้อมูล</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

 <div class="text-center mt-4">
            <a href="/profile" class="btn btn-custom btn-secondary-custom">กลับไปหน้าโปรไฟล์</a>
        </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
