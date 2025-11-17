<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// --- ROUTE BARU UNTUK LANDING PAGE (Welcome/Landing) ---
// Ganti atau timpa rute '/' lama dengan yang ini.
Route::get('/SignUp', function () {
    return Inertia::render('SignUp');
    });
Route::get('/Login', function () {
    return Inertia::render('Login');
    });
Route::get('/', function () {
    return Inertia::render('LandingPage');
    })->name('welcome'); // Tambahkan nama rute 'welcome' agar bisa dipanggil di navbar Vue

// --- Rute Dummy untuk Navigasi ---
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
Route::get('/profile', function () {
    return Inertia::render('Profile');
    })->name('profile');
Route::get('/admin', function () {
    return Inertia::render('Admin');
    })->name('admin');
Route::get('/admin-panel', function () {
    return Inertia::render('AdminPanel');
    })->name('admin-panel');
Route::get('/operator', function () {
    return Inertia::render('Operator');
    })->name('operator');

// --- ROUTE LAINNYA ---
// Middleware ('auth') DIHAPUS SEMENTARA untuk development frontend
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
    })->name('dashboard');

// Route untuk halaman cetak struk (PrintStrukPembayaran.vue)
Route::get('/print-struk', function () {
    $station = request('station');
    $total   = request('total');
    return Inertia::render('PrintStrukPembayaran', [
        'station' => $station,
        'total'   => $total
    ]);
    })->name('print.struk');


require __DIR__ . '/auth.php';