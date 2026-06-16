<?php

namespace App\Http\Controllers\Beranda;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardWargaController extends Controller
{
    /**
     * Dashboard warga: ringkasan + riwayat pengaduan milik akun yang login.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Ringkasan jumlah pengaduan milik warga ini per status
        $base = Pengaduan::where('user_id', $userId);
        $stats = [
            'total'    => (clone $base)->count(),
            'menunggu' => (clone $base)->where('status', 'Menunggu')->count(),
            'diproses' => (clone $base)->where('status', 'Diproses')->count(),
            'selesai'  => (clone $base)->where('status', 'Selesai')->count(),
        ];

        // Daftar "Riwayat Pengaduan Saya" dengan pencarian & filter status
        $query = Pengaduan::where('user_id', $userId);

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('nomor_tiket', 'like', '%' . $search . '%')
                    ->orWhere('judul', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $pengaduans = $query->latest()->paginate(8)->withQueryString();

        return view('content-app.content-dashboard-warga', compact('stats', 'pengaduans'));
    }
}
