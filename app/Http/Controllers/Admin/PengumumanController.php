<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengumuman::latest('id');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $pengumumans = $query->paginate(10)->withQueryString();

        return view('content-admin.content-pengumuman', compact('pengumumans'));
    }

    public function store(Request $request)
    {
        $data = $this->validateInput($request);

        $data['status']  = $this->resolveStatus($request);
        $data['slug']    = $this->uniqueSlug($data['judul']);
        $data['user_id'] = Auth::id();
        $data['gambar']  = $request->hasFile('gambar')
            ? $request->file('gambar')->store('pengumuman', 'public')
            : null;
        $data['tanggal_terbit'] = $data['status'] === 'Publish' ? now() : null;

        $p = Pengumuman::create($data);

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'Tambah Pengumuman',
            'target'     => $p->judul,
            'keterangan' => 'Status: ' . $p->status,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $data = $this->validateInput($request);

        $data['status'] = $this->resolveStatus($request);

        if ($data['judul'] !== $pengumuman->judul) {
            $data['slug'] = $this->uniqueSlug($data['judul'], $pengumuman->id);
        }

        if ($request->hasFile('gambar')) {
            if ($pengumuman->gambar) Storage::disk('public')->delete($pengumuman->gambar);
            $data['gambar'] = $request->file('gambar')->store('pengumuman', 'public');
        } else {
            unset($data['gambar']);
        }

        $data['tanggal_terbit'] = $data['status'] === 'Publish'
            ? ($pengumuman->tanggal_terbit ?? now())
            : null;

        $pengumuman->update($data);

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'Update Pengumuman',
            'target'     => $pengumuman->judul,
            'keterangan' => 'Pengumuman diperbarui.',
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $judul = $pengumuman->judul;
        if ($pengumuman->gambar) Storage::disk('public')->delete($pengumuman->gambar);
        $pengumuman->delete();

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'Hapus Pengumuman',
            'target'     => $judul,
            'keterangan' => 'Pengumuman dihapus.',
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    private function validateInput(Request $request): array
    {
        return $request->validate([
            'judul'     => ['required', 'string', 'max:200'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'isi'       => ['required', 'string'],
            'gambar'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    private function resolveStatus(Request $request): string
    {
        if ($request->boolean('arsip')) {
            return 'Arsip';
        }
        return $request->boolean('publish') ? 'Publish' : 'Draft';
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'pengumuman';
        $slug = $base;
        $i = 1;
        while (Pengumuman::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
