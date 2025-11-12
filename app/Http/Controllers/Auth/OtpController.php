<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OtpController extends Controller
{
    // 🔹 Menampilkan form OTP
    public function showForm(User $user)
    {
        return inertia('Auth/VerifyOtp', [
            'user' => $user,
        ]);
    }

    // 🔹 Verifikasi OTP
    public function verify(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required|string',
        ]);

        $otpCode = OtpCode::where('user_id', $request->user_id)
            ->where('otp', $request->otp)
            ->where('is_used', false)
            ->first();

        if (!$otpCode) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah digunakan.']);
        }

        if ($otpCode->expires_at->isPast()) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa.']);
        }

        // 🔹 Tandai OTP sebagai digunakan
        $otpCode->update(['is_used' => true]);

        // 🔹 Tandai user sebagai diverifikasi
        $otpCode->user->update(['phone_verified_at' => now()]);

        Log::info("User {$otpCode->user->username} berhasil verifikasi OTP");

        return redirect()->route('login')->with('status', 'Nomor telepon berhasil diverifikasi!');
    }
}
