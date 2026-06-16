<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Batasi akses panel ke petugas (admin & superadmin).
     * Akun masyarakat tidak boleh masuk ke area administrasi.
     */
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless(
            in_array(optional($request->user())->role, ['admin', 'superadmin'], true),
            403,
            'Akses khusus petugas.'
        );

        return $next($request);
    }
}
