<?php

namespace App\Http\Controllers\Pengaduan;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\RatingPengaduan;
use App\Models\TanggapanPengaduan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{
    /**
     * Tampilkan halaman beranda / form pengaduan.
     */
    public function index(): View
    {
        return view('content-app.content-pengaduan');
    }

    /**
     * Generate nomor tiket unik dengan format PDU-YYYY-XXX.
     * Menggunakan DB transaction + lockForUpdate untuk mencegah
     * race condition jika ada request bersamaan.
     */
    private function generateNomorTiket(): string
    {
        $year = now()->year;

        // Hitung jumlah pengaduan di tahun ini secara aman
        $count = Pengaduan::whereYear('created_at', $year)
            ->lockForUpdate()
            ->count();

        $urutan = $count + 1;

        // Format: PDU-2025-001, PDU-2025-012, PDU-2025-123, dst.
        $nomor = sprintf('PDU-%d-%03d', $year, $urutan);

        // Pastikan nomor belum ada (antisipasi jika ada data terhapus)
        while (Pengaduan::where('nomor_tiket', $nomor)->exists()) {
            $urutan++;
            $nomor = sprintf('PDU-%d-%03d', $year, $urutan);
        }

        return $nomor;
    }

    /**
     * Simpan pengaduan baru dari form publik.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input
        $validated = $request->validate([
            'kategori' => ['required', 'in:Infrastruktur,Kebersihan,Keamanan,Administrasi,Sosial,Lainnya'],
            'nama_pelapor' => ['required', 'string', 'max:100'],
            'nomor_hp' => ['required', 'string', 'max:20', 'regex:/^[0-9\-\+\s]+$/'],
            'rt_rw' => ['required', 'string', 'max:10'],
            'urgensi' => ['required', 'in:Rendah,Sedang,Tinggi'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'min:20'],
            'foto'             => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'latitude'         => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'        => ['nullable', 'numeric', 'between:-180,180'],
            'alamat_koordinat' => ['nullable', 'string', 'max:255'],
        ], [
            'kategori.required' => 'Pilih salah satu kategori pengaduan.',
            'kategori.in' => 'Kategori pengaduan tidak valid.',
            'nama_pelapor.required' => 'Nama lengkap wajib diisi.',
            'nama_pelapor.max' => 'Nama maksimal 100 karakter.',
            'nomor_hp.required' => 'Nomor HP wajib diisi.',
            'nomor_hp.regex' => 'Format nomor HP tidak valid. Gunakan format: 08xx-xxxx-xxxx.',
            'rt_rw.required' => 'RT/RW wajib diisi.',
            'urgensi.required' => 'Pilih tingkat urgensi.',
            'urgensi.in' => 'Tingkat urgensi tidak valid.',
            'judul.required' => 'Judul pengaduan wajib diisi.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi pengaduan wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal 20 karakter.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        // 2. Bungkus dalam DB transaction agar generate tiket + insert atomic
        $pengaduan = DB::transaction(function () use ($validated, $request) {

            // 2a. Upload foto jika ada
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('pengaduan/foto', 'public');
            }

            // 2b. Generate nomor tiket di dalam transaction
            $nomorTiket = $this->generateNomorTiket();

            // 2c. Simpan ke database (terhubung ke akun yang login)
            return Pengaduan::create([
                'user_id'          => Auth::id(),
                'nomor_tiket'      => $nomorTiket,
                'kategori'         => $validated['kategori'],
                'nama_pelapor'     => $validated['nama_pelapor'],
                'nomor_hp'         => $validated['nomor_hp'],
                'rt_rw'            => $validated['rt_rw'],
                'urgensi'          => $validated['urgensi'],
                'judul'            => $validated['judul'],
                'deskripsi'        => $validated['deskripsi'],
                'foto'             => $fotoPath,
                'latitude'         => $validated['latitude'] ?? null,
                'longitude'        => $validated['longitude'] ?? null,
                'alamat_koordinat' => $validated['alamat_koordinat'] ?? null,
                'status'           => 'Menunggu',
            ]);
        });

        // 3. Redirect kembali ke halaman pengaduan agar notif tiket tampil
        return redirect()
            ->route('pengaduan')
            ->with('tiket_baru', $pengaduan->nomor_tiket);
    }

    /**
     * Lacak pengaduan berdasarkan nomor tiket.
     * Diakses via GET /lacak?tiket=PDU-2025-001
     */
    public function lacak(Request $request): View
    {
        $pengaduan = null;
        $tiketNotFound = false;

        if ($request->filled('tiket')) {

            // Validasi format tiket sebelum query ke DB
            $request->validate([
                'tiket' => ['required', 'string', 'regex:/^PDU-\d{4}-\d{3,}$/i'],
            ], [
                'tiket.regex' => 'Format nomor tiket tidak valid. Gunakan format PDU-YYYY-XXX.',
            ]);

            $pengaduan = Pengaduan::with([
                    'tanggapan' => function ($q) {
                        $q->where('is_internal', false)->orderBy('created_at');
                    },
                    'rating',
                ])
                ->where('nomor_tiket', strtoupper(trim($request->tiket)))
                ->first();

            // Tandai agar view bisa membedakan "belum cari" vs "tidak ditemukan"
            if (!$pengaduan) {
                $tiketNotFound = true;
            }
        }

        return view('content-app.content-pengaduan', compact('pengaduan', 'tiketNotFound'));
    }

    public function storeTanggapanPublik(Request $request)
    {
        $data = $request->validate([
            'nomor_tiket'   => ['required', 'string'],
            'nama_pengirim' => ['required', 'string', 'max:100'],
            'isi'           => ['required', 'string', 'min:3'],
        ]);

        $pengaduan = Pengaduan::where('nomor_tiket', strtoupper(trim($data['nomor_tiket'])))->firstOrFail();

        TanggapanPengaduan::create([
            'pengaduan_id'  => $pengaduan->id,
            'user_id'       => null,
            'pengirim'      => 'Pelapor',
            'nama_pengirim' => $data['nama_pengirim'],
            'isi'           => $data['isi'],
            'is_internal'   => false,
        ]);

        return redirect()
            ->route('pengaduan.lacak', ['tiket' => $pengaduan->nomor_tiket])
            ->with('tanggapan_sukses', true);
    }

    public function storeRatingPublik(Request $request)
    {
        $data = $request->validate([
            'nomor_tiket'  => ['required', 'string'],
            'nama_pelapor' => ['required', 'string', 'max:100'],
            'bintang'      => ['required', 'integer', 'between:1,5'],
            'ulasan'       => ['nullable', 'string', 'max:1000'],
        ]);

        $pengaduan = Pengaduan::where('nomor_tiket', strtoupper(trim($data['nomor_tiket'])))->firstOrFail();

        if ($pengaduan->status !== 'Selesai') {
            return back()->withErrors(['rating' => 'Rating hanya bisa diberikan setelah pengaduan berstatus Selesai.']);
        }

        RatingPengaduan::updateOrCreate(
            ['pengaduan_id' => $pengaduan->id],
            [
                'nama_pelapor' => $data['nama_pelapor'],
                'bintang'      => $data['bintang'],
                'ulasan'       => $data['ulasan'] ?? null,
            ]
        );

        return redirect()
            ->route('pengaduan.lacak', ['tiket' => $pengaduan->nomor_tiket])
            ->with('rating_sukses', true);
    }
}