<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless(
            optional($request->user())->role === 'superadmin',
            403,
            'Akses khusus Super Admin.'
        );

        return $next($request);
    }
}
