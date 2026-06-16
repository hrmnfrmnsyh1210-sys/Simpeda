<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;

class KategoriController extends Controller
{
    public static $kategoriList = [
        'Infrastruktur' => ['icon' => 'bi-building', 'color' => 'blue'],
        'Kebersihan'    => ['icon' => 'bi-trash', 'color' => 'green'],
        'Keamanan'      => ['icon' => 'bi-shield-check', 'color' => 'red'],
        'Administrasi'  => ['icon' => 'bi-file-text', 'color' => 'purple'],
        'Sosial'        => ['icon' => 'bi-people', 'color' => 'amber'],
        'Lainnya'       => ['icon' => 'bi-three-dots', 'color' => 'gray'],
    ];

    public function index()
    {
        $stats = collect(self::$kategoriList)->map(function ($meta, $nama) {
            return [
                'nama'     => $nama,
                'icon'     => $meta['icon'],
                'color'    => $meta['color'],
                'total'    => Pengaduan::where('kategori', $nama)->count(),
                'menunggu' => Pengaduan::where('kategori', $nama)->where('status', 'Menunggu')->count(),
                'diproses' => Pengaduan::where('kategori', $nama)->where('status', 'Diproses')->count(),
                'selesai'  => Pengaduan::where('kategori', $nama)->where('status', 'Selesai')->count(),
                'ditolak'  => Pengaduan::where('kategori', $nama)->where('status', 'Ditolak')->count(),
            ];
        });

        $totalSemua = Pengaduan::count() ?: 1;

        return view('content-admin.content-kategori', compact('stats', 'totalSemua'));
    }
}
