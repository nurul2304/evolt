<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// --- ROUTE BARU UNTUK LANDING PAGE (Welcome/Landing) ---
// Ganti atau timpa rute '/' lama dengan yang ini.
Route::get('/', function () {
    // Memanggil komponen Vue di resources/js/Pages/LandingPage.vue
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
});
Route::get('/register', function () {
    return Inertia::render('Register');
});

// --- ROUTE LAINNYA ---
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/auth.php';
