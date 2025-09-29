<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Portfolio; // ใช้โมเดล Portfolio
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf; 
use Exception;
class ReportController extends Controller
{
  
    //บันทึกข้อมูล CV
     public function store(Request $request)
    {
        try {
            Log::info('Starting CV store()', ['user_id' => Auth::id()]);

            // 1) Validate ให้ตรงกับฟอร์ม
            $validated = $request->validate([
                'name'              => ['required','string','max:255'],
                'lastname'          => ['required','string','max:255'],
                'nickname'          => ['nullable','string','max:255'],
                'age'               => ['nullable','string','max:50'],
                'address'           => ['nullable','string','max:500'],
                'company'           => ['nullable','string','max:255'],
                'education'         => ['nullable','string','max:255'],
                'major'             => ['nullable','string','max:255'],
                'introduce'         => ['nullable','string'],
                'skill_programming' => ['nullable','string'],
                'general_skill'     => ['nullable','string'],
                'experience'        => ['nullable','string'],
                'activity'          => ['nullable','string'],

                'profile_picture'   => ['nullable','image','mimes:jpg,jpeg,png,gif,heic,heif','max:5120'],

                'section1_title'    => ['nullable','string','max:255'],
                'section1_image'    => ['nullable','image','mimes:jpg,jpeg,png,gif,heic,heif','max:5120'],

                'section2_title'    => ['nullable','string','max:255'],
                'section2_image'    => ['nullable','image','mimes:jpg,jpeg,png,gif,heic,heif','max:5120'],

                'section3_title'    => ['nullable','string','max:255'],
                'section3_image'    => ['nullable','image','mimes:jpg,jpeg,png,gif,heic,heif','max:5120'],

                'section4_title'    => ['nullable','string','max:255'],
                'section4_image'    => ['nullable','image','mimes:jpg,jpeg,png,gif,heic,heif','max:5120'],
            ]);

            Log::info('CV validated', ['fields' => array_keys($validated)]);

            // 2) ทำเกี่ยวกับรูปภาพทั้งหมด เป็นส่วนที่ช่วยกำหนด path และชื่อ ในการเซฟลง storage
            $storeOneImage = function ($file, string $dir) {
                if (!$file) return null; // คอลัมน์ json เป็น nullable
                $path = $file->store($dir, 'public'); // storage/app/public/...
                return [
                    'path' => 'storage/'.$path,                 // ใช้แสดงใน Blade
                    'name' => $file->getClientOriginalName(),
                    'mime' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ];
            };

            // 3) สร้างออบเจ็กต์แล้วตั้งค่า
            $report = new Portfolio($validated); // << สำคัญ: ใช้ Portfolio (ตาม model)
            $report->profile_picture = $storeOneImage($request->file('profile_picture'), 'profile_pictures');

            $report->section1_image  = $storeOneImage($request->file('section1_image'), 'portfolio_sections/1');
            $report->section2_image  = $storeOneImage($request->file('section2_image'), 'portfolio_sections/2');
            $report->section3_image  = $storeOneImage($request->file('section3_image'), 'portfolio_sections/3');
            $report->section4_image  = $storeOneImage($request->file('section4_image'), 'portfolio_sections/4');

            // 4) บันทึก
            $report->save();

            Log::info('CV saved', ['cv_id' => $report->id]);

            return redirect()->route('user.reports')->with('success', 'บันทึก CV สำเร็จ (#'.$report->id.')');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('CV validation failed', [
                'errors'  => $e->errors(),
                'user_id' => Auth::id()
            ]);
            return back()->withErrors($e->errors())->withInput();

        } catch (Exception $e) {
            Log::error('CV unexpected error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);

            // โชว์ข้อความจริงเฉพาะตอน debug = true
            $msg = config('app.debug') ? $e->getMessage() : 'เกิดข้อผิดพลาดที่ไม่คาดคิด กรุณาลองใหม่อีกครั้ง';
            return back()->with('error', $msg)->withInput();
        }
    }
  
//ดึงข้อมูลแสดงตาราง
 public function userReports()
    {
        // ดึงแค่คอลัมน์ที่ต้องใช้ เรียงจากใหม่ไปเก่า
        $cvs = Portfolio::select('id', 'name', 'lastname', 'company')
            ->orderBy('id', 'desc')
            ->get();

        return view('user_reports', compact('cvs'));
    }

    
    //แสดง CV
     public function showCv($id)
    {
        // ดึงข้อมูล CV ตาม id (ถ้าไม่เจอจะ 404)
        $cv = Portfolio::findOrFail($id);

        // ส่งไป Blade ใหม่ (ไฟล์ cv_show.blade.php)
        return view('cv_show', compact('cv'));
    }

    //ดาวโหลด PDF
     public function downloadCv($id)
    {
        $cv = Portfolio::findOrFail($id);

        // ดึง path รูปจาก JSON
        $pp   = is_array($cv->profile_picture) ? ($cv->profile_picture['path'] ?? null) : $cv->profile_picture;
        $img1 = is_array($cv->section1_image)  ? ($cv->section1_image['path']  ?? null) : $cv->section1_image;
        $img2 = is_array($cv->section2_image)  ? ($cv->section2_image['path']  ?? null) : $cv->section2_image;
        $img3 = is_array($cv->section3_image)  ? ($cv->section3_image['path']  ?? null) : $cv->section3_image;
        $img4 = is_array($cv->section4_image)  ? ($cv->section4_image['path']  ?? null) : $cv->section4_image;

        // แปลงเป็น absolute file path ให้ Dompdf อ่าน (ไฟล์อยู่ใน public/)
        $paths = [
            'pp'   => $pp   ? public_path($pp)   : null,
            'img1' => $img1 ? public_path($img1) : null,
            'img2' => $img2 ? public_path($img2) : null,
            'img3' => $img3 ? public_path($img3) : null,
            'img4' => $img4 ? public_path($img4) : null,
        ];

        $pdf = Pdf::loadView('cv.pdf', [
                'cv'    => $cv,
                'paths' => $paths, // ส่ง path file ให้ <img src="...">
            ])
            ->setPaper('a4', 'portrait'); // ตั้งกระดาษ

        return $pdf->download('cv-'.$cv->id.'.pdf');
    }

}
