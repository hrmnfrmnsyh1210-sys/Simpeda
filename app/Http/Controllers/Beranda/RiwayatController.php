<?php

namespace App\Http\Controllers\Beranda;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan; // Pastikan nama model sesuai
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Menampilkan riwayat pengaduan dengan fitur pencarian dan filter.
     */
    public function index(Request $request)
    {
        // 1. Inisialisasi query
        $query = Pengaduan::query();

        // 2. Fitur Pencarian (q)
        // Mencari berdasarkan nomor tiket atau judul laporan
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('nomor_tiket', 'like', '%' . $search . '%')
                    ->orWhere('judul', 'like', '%' . $search . '%');
            });
        }

        // 3. Fitur Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // 4. Urutkan berdasarkan data terbaru dan ambil pagination
        // Menggunakan 10 data per halaman
        $pengaduans = $query->latest()->paginate(10)->withQueryString();

        // 5. Return ke view
        // Pastikan path view sesuai dengan lokasi file blade Anda
        return view('content-app.content-riwayat', compact('pengaduans'));
    }
}