<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaAdminController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $authRole = $user->role;

        $totalPengaduan = Pengaduan::count();
        $pengaduanMasuk = Pengaduan::where('status', 'Menunggu')->count();
        $pengaduanProses = Pengaduan::where('status', 'Diproses')->count();
        $pengaduanSelesai = Pengaduan::where('status', 'Selesai')->count();
        $totalUser = User::count();

        $recentPengaduan = Pengaduan::query()
            ->when(
                $request->search,
                fn($q) =>
                $q->where('nomor_tiket', 'like', "%{$request->search}%")
                    ->orWhere('nama_pelapor', 'like', "%{$request->search}%")
                    ->orWhere('judul', 'like', "%{$request->search}%")
            )
            ->when(
                $request->kategori,
                fn($q) =>
                $q->where('kategori', $request->kategori)
            )
            ->when(
                $request->status,
                fn($q) =>
                $q->where('status', $request->status)
            )
            ->latest()
            ->take(6)
            ->get();

        return view('content-admin.content-dashboard', compact(
            'user',
            'authRole',
            'totalPengaduan',
            'pengaduanMasuk',
            'pengaduanProses',
            'pengaduanSelesai',
            'totalUser',
            'recentPengaduan',
        ));
    }
}