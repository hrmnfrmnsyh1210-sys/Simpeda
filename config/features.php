<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Fitur Hapus (Panel Superadmin)
    |--------------------------------------------------------------------------
    |
    | Saklar tunggal untuk semua tombol & endpoint hapus di panel admin yang
    | hanya bisa diakses superadmin: Pengaduan, Pengumuman, Struktur
    | Organisasi, dan Manajemen Akun. Sedang dinonaktifkan sementara.
    |
    | Untuk mengaktifkan lagi: set FEATURE_HAPUS_SUPERADMIN=true di .env,
    | lalu jalankan `php artisan config:clear` (atau config:cache ulang).
    |
    */
    'hapus_superadmin' => env('FEATURE_HAPUS_SUPERADMIN', false),

];
