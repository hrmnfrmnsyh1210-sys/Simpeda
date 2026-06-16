<?php

namespace App\Http\Controllers\Beranda;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;

class ProfilDesaController extends Controller
{
    public function index()
    {
        $struktur = StrukturOrganisasi::where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        $penghargaan = [
            ['tahun' => '2023', 'judul' => 'Desa Terbaik Tingkat Kecamatan',          'pemberi' => 'Pemerintah Kecamatan'],
            ['tahun' => '2022', 'judul' => 'Pelayanan Publik Terbaik',                'pemberi' => 'Pemerintah Kabupaten'],
            ['tahun' => '2021', 'judul' => 'Desa Tertib Administrasi',                'pemberi' => 'Pemerintah Kabupaten'],
        ];

        return view('content-app.content-profil-desa', compact('struktur', 'penghargaan'));
    }
}
