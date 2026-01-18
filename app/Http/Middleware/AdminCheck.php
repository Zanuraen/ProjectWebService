<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sedang login DAN apakah is_admin bernilai true
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Jika bukan admin, lempar kembali ke halaman utama
        return redirect('/')->with('error', 'Akses Ditolak: Halaman ini khusus untuk Admin.');
    }
}