<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('content-admin.content-users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:admin,superadmin',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required'      => 'Role wajib dipilih.',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'is_active' => true,
        ]);

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'Tambah Akun',
            'target'     => $user->name . ' (' . $user->role . ')',
            'keterangan' => 'Akun baru ditambahkan dengan email ' . $user->email,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Akun ' . $user->name . ' berhasil ditambahkan.');
    }

    public function toggleActive(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak dapat menonaktifkan akun sendiri.');
        }

        $user->update(['is_active' => !$user->is_active]);

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => $user->is_active ? 'Aktifkan Akun' : 'Nonaktifkan Akun',
            'target'     => $user->name,
            'keterangan' => 'Status akun diubah menjadi ' . ($user->is_active ? 'aktif' : 'nonaktif'),
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Status akun ' . $user->name . ' berhasil diubah.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $name = $user->name;
        $user->delete();

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'Hapus Akun',
            'target'     => $name,
            'keterangan' => 'Akun ' . $name . ' dihapus dari sistem.',
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Akun ' . $name . ' berhasil dihapus.');
    }
}
