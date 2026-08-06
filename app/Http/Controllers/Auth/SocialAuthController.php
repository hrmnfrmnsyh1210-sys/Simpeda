<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class SocialAuthController extends Controller
{
    /**
     * Arahkan warga ke halaman consent Google.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Tangani callback dari Google: buat akun warga baru atau masuk ke akun yang sudah ada.
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (InvalidStateException $e) {
            return redirect()->route('login')->with('error', 'Sesi login Google tidak valid. Silakan coba lagi.');
        }

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user && $user->role !== 'masyarakat') {
            return redirect()->route('login')->with('error', 'Akun ini terdaftar sebagai petugas. Silakan masuk menggunakan email & kata sandi petugas.');
        }

        if ($user) {
            if (!$user->is_active) {
                return redirect()->route('login')->with('error', 'Akun Anda dinonaktifkan. Hubungi administrator.');
            }

            $user->forceFill([
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ])->save();
        } else {
            $user = User::create([
                'name'      => $googleUser->getName() ?: $googleUser->getNickname(),
                'email'     => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
                'password'  => null,
                'role'      => 'masyarakat',
                'is_active' => true,
            ]);
        }

        Auth::login($user, true);
        request()->session()->regenerate();

        $user->forceFill(['last_login_at' => now()])->save();

        if (empty($user->nik) || empty($user->nomor_hp)) {
            return redirect()->route('warga.lengkapi-profil');
        }

        return redirect()->intended(route('warga.dashboard'));
    }

    /**
     * Form pelengkap data (NIK, No. HP, RT/RW) untuk akun warga baru dari Google.
     */
    public function showCompleteProfile(): View|RedirectResponse
    {
        if (Auth::user()->nik && Auth::user()->nomor_hp) {
            return redirect()->route('warga.dashboard');
        }

        return view('content-auth.content-lengkapi-profil');
    }

    public function storeCompleteProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nik'      => ['required', 'string', 'digits:16', 'unique:users,nik,' . Auth::id()],
            'nomor_hp' => ['required', 'string', 'max:20', 'regex:/^[0-9\-\+\s]+$/'],
            'rt_rw'    => ['nullable', 'string', 'max:10'],
        ], [
            'nik.required'      => 'NIK wajib diisi.',
            'nik.digits'        => 'NIK harus terdiri dari 16 digit angka.',
            'nik.unique'        => 'NIK ini sudah terdaftar pada akun lain.',
            'nomor_hp.required' => 'Nomor HP wajib diisi.',
            'nomor_hp.regex'    => 'Format nomor HP tidak valid. Gunakan format: 08xx-xxxx-xxxx.',
        ]);

        Auth::user()->update($validated);

        return redirect()->route('warga.dashboard')->with('success', 'Profil berhasil dilengkapi. Selamat datang!');
    }
}
