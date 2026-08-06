<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Tampilkan halaman pendaftaran akun masyarakat (via Google Sign-In).
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('beranda');
        }

        return view('content-auth.content-register');
    }
}
