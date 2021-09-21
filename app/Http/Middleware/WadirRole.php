<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class WadirRole
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
        if($role == 'Admin'){
            return redirect('/admin');
        } else if ($role == 'Mahasiswa') {
            return redirect('/mahasiswa');
        } else if ($role == 'Pembimbing'){
            return redirect('/pembimbing');
        }
        return $next($request);
    }
}
