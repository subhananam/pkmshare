<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role = Auth::user()->role;
        if ($role == 'Mahasiswa') {
            return redirect('/mahasiswa');
        } else if ($role == 'Pembimbing'){
            return redirect('/pembimbing');
        } else if ($role == 'Wadir'){
            return redirect('/wadir');
        }
        return $next($request);
    }
}
