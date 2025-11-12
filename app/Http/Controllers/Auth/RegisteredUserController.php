<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    /**
     * Menampilkan halaman registrasi.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Menangani permintaan registrasi yang masuk.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
  public function store(Request $request): RedirectResponse
{
    $request->validate([
        'username' => 'required|string|max:255|unique:'.User::class,
        'email' => 'required|string|email|max:255|unique:'.User::class,
        'nomor_plat' => 'required|string|max:9|unique:'.User::class,
        'nomor_telepon' => 'required|string|max:13',
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'terms' => 'accepted',
    ]);

    $user = User::create([
        'username' => $request->username,
        'email' => $request->email,
        'nomor_plat' => $request->nomor_plat,
        'nomor_telepon' => $request->nomor_telepon,
        'password' => Hash::make($request->password),
    ]);

    // 🔹 Buat OTP
    $otp = rand(100000, 999999);
    \App\Models\OtpCode::create([
        'user_id' => $user->id,
        'otp' => $otp,
        'expires_at' => now()->addMinutes(5),
    ]);

    // 🔹 Kirim OTP ke user (sementara log aja dulu)
    \Log::info("OTP untuk {$user->username}: {$otp}");

    // 🔹 Redirect ke halaman verifikasi OTP
    return redirect()->route('otp.form', ['user' => $user->id]);
}

    

        // 4. (DIHAPUS) KITA TIDAK LOGIN-KAN USER SECARA OTOMATIS
        // Auth::login($user); // <-- Baris ini dinonaktifkan

        // 5. KIRIM RESPON REDIRECT KE HALAMAN LOGIN
        // Inertia akan menangkap redirect ini dan mengarahkan
        // frontend (Vue) ke halaman login.
     
}



