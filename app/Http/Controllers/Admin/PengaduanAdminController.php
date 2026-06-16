<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Pengaduan;
use App\Models\TanggapanPengaduan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanAdminController extends Controller
{
    /**
     * Menampilkan daftar semua pengaduan.
     */
    public function index(Request $request)
    {
        // Query dasar
        $query = Pengaduan::latest();

        // Filter berdasarkan Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Fitur Pencarian (Nama Pelapor, Judul, atau Nomor Tiket)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelapor', 'like', "%$search%")
                    ->orWhere('judul', 'like', "%$search%")
                    ->orWhere('nomor_tiket', 'like', "%$search%");
            });
        }

        // Ambil data dengan pagination
        $pengaduans = $query->paginate(10)->withQueryString();

        return view('content-admin.content-pengaduan', compact('pengaduans'));
    }

    // detail pengaduan
    public function show($id) {
        $pengaduan = Pengaduan::with(['tanggapan' => function ($q) {
            $q->orderBy('created_at');
        }, 'rating'])->findOrFail($id);

        return view('content-admin.content-pengaduan-detail', compact('pengaduan'));
    }

    public function storeTanggapan(Request $request, $id)
    {
        $request->validate([
            'isi' => ['required', 'string', 'min:3'],
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        TanggapanPengaduan::create([
            'pengaduan_id'  => $pengaduan->id,
            'user_id'       => Auth::id(),
            'pengirim'      => 'Petugas',
            'nama_pengirim' => Auth::user()->name,
            'isi'           => $request->isi,
            'is_internal'   => $request->boolean('is_internal'),
        ]);

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'Balas Pengaduan',
            'target'     => 'Tiket #' . $pengaduan->nomor_tiket,
            'keterangan' => 'Menambah tanggapan baru.',
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Tanggapan berhasil dikirim.');
    }

    public function updateStatus(Request $request, $id)
    {
        // 1. Validasi input
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai,Ditolak',
            'komentar_petugas' => 'nullable|string'
        ]);

        // 2. Cari data pengaduan
        $pengaduan = Pengaduan::findOrFail($id);

        // 3. Update field
        $pengaduan->status = $request->status;

        // Jika request datang dari Form Detail (yang ada input komentar), simpan komentarnya
        if ($request->has('komentar_petugas')) {
            $pengaduan->komentar_petugas = $request->komentar_petugas;
        }

        $pengaduan->save();

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'Update Status',
            'target'     => 'Tiket #' . $pengaduan->nomor_tiket,
            'keterangan' => 'Status diubah menjadi ' . $request->status,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Status Tiket #' . $pengaduan->nomor_tiket . ' berhasil diupdate menjadi ' . $request->status);
    }

    public function exportPdf(Request $request)
    {
        $query = Pengaduan::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelapor', 'like', "%$search%")
                    ->orWhere('judul', 'like', "%$search%")
                    ->orWhere('nomor_tiket', 'like', "%$search%");
            });
        }

        $pengaduans = $query->get();

        $stats = [
            'total'    => Pengaduan::count(),
            'menunggu' => Pengaduan::where('status', 'Menunggu')->count(),
            'diproses' => Pengaduan::where('status', 'Diproses')->count(),
            'selesai'  => Pengaduan::where('status', 'Selesai')->count(),
            'ditolak'  => Pengaduan::where('status', 'Ditolak')->count(),
        ];

        $byKategori = Pengaduan::selectRaw('kategori, count(*) as jumlah')
            ->groupBy('kategori')
            ->orderByDesc('jumlah')
            ->pluck('jumlah', 'kategori');

        $byUrgensi = Pengaduan::selectRaw('urgensi, count(*) as jumlah')
            ->groupBy('urgensi')
            ->orderByDesc('jumlah')
            ->pluck('jumlah', 'urgensi');

        $pdf = Pdf::loadView('content-admin.pdf-summary', compact(
            'pengaduans',
            'stats',
            'byKategori',
            'byUrgensi',
        ) + [
            'filterStatus'   => $request->status,
            'filterKategori' => $request->kategori,
            'filterSearch'   => $request->search,
        ])->setPaper('a4', 'landscape');

        $filename = 'laporan-pengaduan-' . now()->format('Ymd-His') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Hapus Pengaduan (Hanya untuk Superadmin).
     */
    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $tiket = $pengaduan->nomor_tiket;
        $pengaduan->delete();

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'Hapus Pengaduan',
            'target'     => 'Tiket #' . $tiket,
            'keterangan' => 'Pengaduan dengan nomor tiket ' . $tiket . ' dihapus.',
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('admin.pengaduan.index')->with('success', 'Data pengaduan telah dihapus.');
    }
}