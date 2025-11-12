<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\OtpController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/verify-otp/{user}', [OtpController::class, 'showForm'])->name('otp.form');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify');
Route::post('/resend-otp', [OtpController::class, 'resend'])->name('otp.resend');


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dalam grup yang
| berisi grup middleware "web". Buat sesuatu yang hebat!
|
*/

// --- RUTE HALAMAN DEPAN (LANDING PAGE) ---
Route::get('/', function () {
    return Inertia::render('LandingPage');
})->name('welcome');

// --- Rute Dummy untuk Navigasi (Contoh) ---
Route::get('/about', function () {
    return Inertia::render('AboutUs');
})->name('about');
Route::get('/services', function () {
    return Inertia::render('LandingPage');
})->name('services');
Route::get('/blog', function () {
    return Inertia::render('LandingPage');
})->name('blog');
Route::get('/map-results', function () {
    return Inertia::render('MapResults');
});


// --- RUTE YANG MEMBUTUHKAN LOGIN (TERPROTEKSI) ---
Route::middleware(['auth'])->group(function () {

    
    // Rute Dashboard (Sekarang sudah aman)
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Rute untuk Admin & Operator (Juga harus dilindungi)
    Route::get('/admin', function () {
        return Inertia::render('Admin');
    })->name('admin');
    
    Route::get('/admin-panel', function () {
        return Inertia::render('AdminPanel');
    })->name('admin-panel');
    
    Route::get('/operator', function () {
        return Inertia::render('Operator');
    })->name('operator');

    // Rute cetak struk
    Route::get('/print-struk', function () {
        $station = request('station');
        $total   = request('total');
        return Inertia::render('PrintStrukPembayaran', [
            'station' => $station,
            'total'   => $total
        ]);
    })->name('print.struk');

    // CATATAN: Rute 'profile.edit', 'profile.update', 'profile.destroy'
    // sudah otomatis dimuat oleh 'auth.php' di bawah.
    // Kita TIDAK PERLU menambahkannya di sini.
});


// --- RUTE AUTENTIKASI ---
// File ini sudah berisi rute untuk:
// - Login (route('login'))
// - Register (route('register'))
// - Logout (route('logout'))
// - Profile (route('profile.edit'), route('profile.update'))
// JANGAN HAPUS BARIS INI.
require __DIR__ . '/auth.php';

/* --- RUTE YANG DIHAPUS ---
Rute di bawah ini dihapus karena bertabrakan atau
sudah disediakan oleh auth.php:

Route::get('/SignUp', ...);
Route::get('/Login', ...);
Route::get('/profile', ...)->name('profile');
*/