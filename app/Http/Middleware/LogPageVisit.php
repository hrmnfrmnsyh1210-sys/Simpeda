<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogPageVisit
{
    /**
     * Catat kunjungan unik per sesi per hari. Hanya untuk request halaman (GET),
     * agar submit form/aksi POST tidak dihitung sebagai kunjungan baru.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('get') && $request->session()->get('kunjungan_tercatat') !== today()->toDateString()) {
            PageVisit::create([
                'session_id'   => $request->session()->getId(),
                'user_id'      => Auth::id(),
                'ip_address'   => $request->ip(),
                'visited_date' => today(),
                'created_at'   => now(),
            ]);

            $request->session()->put('kunjungan_tercatat', today()->toDateString());
        }

        return $next($request);
    }
}
