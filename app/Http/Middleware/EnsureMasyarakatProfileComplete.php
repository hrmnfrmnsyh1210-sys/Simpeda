<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMasyarakatProfileComplete
{
    /**
     * Warga yang mendaftar via Google belum mengisi NIK & No. HP.
     * Paksa lengkapi profil dulu sebelum memakai fitur pengaduan.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'masyarakat' && (empty($user->nik) || empty($user->nomor_hp))
            && !$request->routeIs('warga.lengkapi-profil*')) {
            return redirect()->route('warga.lengkapi-profil');
        }

        return $next($request);
    }
}
