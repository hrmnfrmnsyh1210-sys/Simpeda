<?php

namespace App\Http\Controllers\Beranda;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class berandaUserController extends Controller
{
    public function index()
    {
        $totalPengaduan = Pengaduan::count();

        $totalSelesai = Pengaduan::where('status', 'Selesai')->count();
        $persenSelesai = $totalPengaduan > 0
            ? round(($totalSelesai / $totalPengaduan) * 100)
            : 0;

        $wilayahTerlayani = Pengaduan::distinct('rt_rw')->whereNotNull('rt_rw')->count('rt_rw');

        return view('content-app.content-beranda', compact(
            'totalPengaduan',
            'persenSelesai',
            'wilayahTerlayani',
        ));
    }
}
