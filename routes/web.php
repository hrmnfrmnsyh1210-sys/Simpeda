<?php

use App\Http\Controllers\Admin\BerandaAdminController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\PengaduanAdminController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\StrukturOrganisasiController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Beranda\berandaUserController;
use App\Http\Controllers\Beranda\DashboardWargaController;
use App\Http\Controllers\Beranda\PengumumanPublikController;
use App\Http\Controllers\Beranda\ProfilDesaController;
use App\Http\Controllers\Beranda\RiwayatController;
use App\Http\Controllers\Beranda\TentangController;
use App\Http\Controllers\Pengaduan\PengaduanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('beranda');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Pendaftaran akun masyarakat (Google Sign-In)
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

    // Masuk/daftar warga dengan akun Google
    Route::get('/login/google', [SocialAuthController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/login/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('google.callback');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// --- Admin Panel (auth + role petugas required) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [BerandaAdminController::class, 'index'])->name('dashboard');

    // Pengaduan
    Route::get('/pengaduan', [PengaduanAdminController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/export/pdf', [PengaduanAdminController::class, 'exportPdf'])->name('pengaduan.exportPdf');
    Route::get('/pengaduan/{id}', [PengaduanAdminController::class, 'show'])->name('pengaduan.show');
    Route::patch('/pengaduan/{id}/update-status', [PengaduanAdminController::class, 'updateStatus'])->name('pengaduan.updateStatus');
    Route::post('/pengaduan/{id}/tanggapan', [PengaduanAdminController::class, 'storeTanggapan'])->name('pengaduan.tanggapan.store');

    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

    // Struktur Organisasi Kantor Desa
    Route::get('/struktur', [StrukturOrganisasiController::class, 'index'])->name('struktur.index');
    Route::post('/struktur', [StrukturOrganisasiController::class, 'store'])->name('struktur.store');
    Route::patch('/struktur/{struktur}', [StrukturOrganisasiController::class, 'update'])->name('struktur.update');
    Route::delete('/struktur/{struktur}', [StrukturOrganisasiController::class, 'destroy'])->name('struktur.destroy');

    // Pengumuman
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::patch('/pengumuman/{pengumuman}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

    // --- Superadmin only ---
    Route::middleware('superadmin')->group(function () {
        // Manajemen Akun Admin
        Route::get('/users', [UserAdminController::class, 'index'])->name('users.index');
        Route::post('/users', [UserAdminController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}/toggle', [UserAdminController::class, 'toggleActive'])->name('users.toggle');
        Route::delete('/users/{user}', [UserAdminController::class, 'destroy'])->name('users.destroy');

        // Log Aktivitas
        Route::get('/log', [LogController::class, 'index'])->name('log.index');

        // Pengaturan
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
    });
});

// Alias lama agar tidak 404 jika masih ada referensi luar
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('superadmin.dashboard');


// --- Publik (beranda masyarakat) ---
Route::get('/beranda', [berandaUserController::class, 'index'])->name('beranda');

// Lengkapi profil (NIK, No. HP) untuk warga yang baru daftar via Google
Route::middleware('auth')->group(function () {
    Route::get('/lengkapi-profil', [SocialAuthController::class, 'showCompleteProfile'])->name('warga.lengkapi-profil');
    Route::post('/lengkapi-profil', [SocialAuthController::class, 'storeCompleteProfile'])->name('warga.lengkapi-profil.store');
});

// Buat pengaduan: wajib login sebagai masyarakat (pengaduan terhubung ke akun)
Route::middleware(['auth', 'profil.lengkap'])->group(function () {
    // Dashboard warga: aksi cepat + riwayat pengaduan milik akun
    Route::get('/dashboard-warga', [DashboardWargaController::class, 'index'])->name('warga.dashboard');

    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
});

Route::get('/lacak', [PengaduanController::class, 'lacak'])->name('pengaduan.lacak');
Route::post('/lacak/tanggapan', [PengaduanController::class, 'storeTanggapanPublik'])->name('pengaduan.lacak.tanggapan');
Route::post('/lacak/rating', [PengaduanController::class, 'storeRatingPublik'])->name('pengaduan.lacak.rating');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');
Route::get('/profil-desa', [ProfilDesaController::class, 'index'])->name('profil-desa');
Route::get('/riwayat-pengaduan', [RiwayatController::class, 'index'])->name('riwayat');

// Pengumuman publik
Route::get('/pengumuman', [PengumumanPublikController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{slug}', [PengumumanPublikController::class, 'show'])->name('pengumuman.show');

// FAQ digabung ke halaman Tentang
Route::redirect('/faq', '/tentang#faq')->name('faq.index');
