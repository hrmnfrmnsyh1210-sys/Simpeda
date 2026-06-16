<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Tampilkan halaman pendaftaran akun masyarakat.
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('beranda');
        }

        return view('content-auth.content-register');
    }

    /**
     * Proses pendaftaran akun masyarakat baru.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'nik'      => ['required', 'string', 'digits:16', 'unique:users,nik'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'nomor_hp' => ['required', 'string', 'max:20', 'regex:/^[0-9\-\+\s]+$/'],
            'rt_rw'    => ['nullable', 'string', 'max:10'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'nik.required'      => 'NIK wajib diisi.',
            'nik.digits'        => 'NIK harus terdiri dari 16 digit angka.',
            'nik.unique'        => 'NIK ini sudah terdaftar. Silakan masuk.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format alamat email tidak valid.',
            'email.unique'      => 'Email ini sudah terdaftar. Silakan masuk.',
            'nomor_hp.required' => 'Nomor HP wajib diisi.',
            'nomor_hp.regex'    => 'Format nomor HP tidak valid. Gunakan format: 08xx-xxxx-xxxx.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min'      => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'nik'       => $validated['nik'],
            'email'     => $validated['email'],
            'nomor_hp'  => $validated['nomor_hp'],
            'rt_rw'     => $validated['rt_rw'] ?? null,
            'password'  => Hash::make($validated['password']),
            'role'      => 'masyarakat',
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('warga.dashboard')
            ->with('success', 'Pendaftaran berhasil. Selamat datang, ' . $user->name . '!');
    }
}
