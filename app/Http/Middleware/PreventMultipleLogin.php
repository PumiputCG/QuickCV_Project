<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventMultipleLogin
{
    public function handle(Request $request, Closure $next)
{
    $user = Auth::user();

    // ผู้ใช้งานล็อคอิน / ผู้ใช้งานมี session (คนพึ่งสมัครจะไม่ติดตรงนี้) / ตรวจสอบ session ใหม่และเก่า
    if ($user && $user->session_id && $user->session_id !== session()->getId()) {
        Auth::logout();
        return redirect('/')->with('error', 'บัญชีนี้มีการเข้าสู่ระบบจากอุปกรณ์อื่น');
    }

    return $next($request);
}

}