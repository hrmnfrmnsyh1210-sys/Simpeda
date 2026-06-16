<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->intended($this->redirectPath(Auth::user()->role));
        }

        return view('content-auth.content-login');
    }

    /**
     * Proses login dengan validasi lengkap.
     */
    public function login(Request $request): RedirectResponse
    {
        // 1. Validasi input (masyarakat pakai NIK, petugas pakai email)
        $request->validate([
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'login.required' => 'Email atau NIK wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        // 2. Cek rate limiting
        $this->ensureIsNotRateLimited($request);

        // 3. Tentukan kredensial: 16 digit angka dianggap NIK, selain itu email
        $loginInput = trim($request->input('login'));
        $field = (ctype_digit($loginInput) && strlen($loginInput) === 16) ? 'nik' : 'email';

        $credentials = [$field => $loginInput, 'password' => $request->input('password')];
        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($this->throttleKey($request));

            throw ValidationException::withMessages([
                'login' => 'Email/NIK atau kata sandi yang Anda masukkan salah.',
            ]);
        }

        // 4. Reset rate limiter
        RateLimiter::clear($this->throttleKey($request));

        // 5. Cek status akun
        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'login' => 'Akun Anda dinonaktifkan. Hubungi administrator.',
            ]);
        }

        // 6. Regenerate session
        $request->session()->regenerate();

        // 7. Redirect berdasarkan role (Sudah diperbarui ke superadmin & admin)
        return redirect()->intended($this->redirectPath($user->role));
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda')->with('success', 'Anda berhasil keluar dari sistem.');
    }

    /**
     * Tentukan halaman redirect berdasarkan role.
     * PERUBAHAN: admin & user -> superadmin & admin
     */
    protected function redirectPath(?string $role = null): string
    {
        return match ($role) {
            'superadmin' => route('superadmin.dashboard'),
            'admin' => route('admin.dashboard'),
            'masyarakat' => route('warga.dashboard'),
            default => route('beranda'),
        };
    }

    /**
     * Pastikan request belum melebihi batas percobaan login.
     */
    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'login' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
        ]);
    }

    /**
     * Buat throttle key unik per identitas (email/NIK) + IP.
     */
    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(
            Str::lower($request->input('login')) . '|' . $request->ip()
        );
    }
}