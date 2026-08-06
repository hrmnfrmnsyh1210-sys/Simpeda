<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Fitur Hapus (Panel Superadmin)
    |--------------------------------------------------------------------------
    |
    | Saklar per-area untuk tombol & endpoint hapus di panel superadmin.
    | Manajemen Akun, Struktur Organisasi, dan Pengumuman aktif kembali.
    | Hapus Pengaduan sengaja tetap dinonaktifkan (riwayat pengaduan tidak
    | boleh dihapus dari sistem).
    |
    */
    'hapus_pengaduan'  => env('FEATURE_HAPUS_PENGADUAN', false),
    'hapus_users'      => env('FEATURE_HAPUS_USERS', true),
    'hapus_struktur'   => env('FEATURE_HAPUS_STRUKTUR', true),
    'hapus_pengumuman' => env('FEATURE_HAPUS_PENGUMUMAN', true),

];
