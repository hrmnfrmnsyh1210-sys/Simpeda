<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StrukturOrganisasiController extends Controller
{
    public function index(Request $request)
    {
        $query = StrukturOrganisasi::query()->orderBy('urutan')->orderBy('id');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('jabatan', 'like', "%$s%")
                  ->orWhere('nama', 'like', "%$s%")
                  ->orWhere('nip', 'like', "%$s%");
            });
        }

        $strukturs = $query->paginate(15)->withQueryString();

        return view('content-admin.content-struktur', compact('strukturs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jabatan'   => ['required', 'string', 'max:100'],
            'nama'      => ['required', 'string', 'max:100'],
            'nip'       => ['nullable', 'string', 'max:30'],
            'urutan'    => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['urutan']    = $data['urutan'] ?? 0;

        $item = StrukturOrganisasi::create($data);

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'Tambah Struktur Organisasi',
            'target'     => $item->jabatan,
            'keterangan' => 'Menambah pejabat: ' . $item->nama . ' (' . $item->jabatan . ')',
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Struktur {$item->jabatan} berhasil ditambahkan.");
    }

    public function update(Request $request, StrukturOrganisasi $struktur)
    {
        $data = $request->validate([
            'jabatan'   => ['required', 'string', 'max:100'],
            'nama'      => ['required', 'string', 'max:100'],
            'nip'       => ['nullable', 'string', 'max:30'],
            'urutan'    => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['urutan']    = $data['urutan'] ?? 0;

        $struktur->update($data);

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'Update Struktur Organisasi',
            'target'     => $struktur->jabatan,
            'keterangan' => 'Memperbarui data: ' . $struktur->nama,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Struktur {$struktur->jabatan} berhasil diperbarui.");
    }

    public function destroy(StrukturOrganisasi $struktur)
    {
        $jabatan = $struktur->jabatan;
        $nama    = $struktur->nama;
        $struktur->delete();

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'Hapus Struktur Organisasi',
            'target'     => $jabatan,
            'keterangan' => 'Menghapus: ' . $nama . ' (' . $jabatan . ')',
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', "Struktur {$jabatan} berhasil dihapus.");
    }
}
