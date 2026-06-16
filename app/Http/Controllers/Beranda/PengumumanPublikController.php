<?php

namespace App\Http\Controllers\Beranda;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;

class PengumumanPublikController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::where('status', 'Publish')
            ->orderByDesc('tanggal_terbit')
            ->paginate(9);

        return view('content-app.content-pengumuman', compact('pengumumans'));
    }

    public function show(string $slug)
    {
        $pengumuman = Pengumuman::where('slug', $slug)
            ->where('status', 'Publish')
            ->firstOrFail();

        $pengumuman->increment('views');

        $lainnya = Pengumuman::where('status', 'Publish')
            ->where('id', '!=', $pengumuman->id)
            ->orderByDesc('tanggal_terbit')
            ->limit(3)
            ->get();

        return view('content-app.content-pengumuman-detail', compact('pengumuman', 'lainnya'));
    }
}
