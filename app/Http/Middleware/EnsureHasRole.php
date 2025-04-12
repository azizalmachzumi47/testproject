<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role_id): Response
    {
        if (!Auth::check()) {
            return redirect()->route('auth');
        }

        $user = Auth::user();

        // Cek apakah role_id cocok
        if ((int) $user->role_id !== (int) $role_id) {
            // Redirect ke halaman sesuai role
            if ($user->role_id === 1) {
                return redirect()->route('admin');
            } elseif ($user->role_id === 2) {
                return redirect()->route('user');
            } else {
                return redirect()->route('auth')->with('error', 'Anda tidak memiliki akses ke halaman ini!');
            }
        }

        return $next($request);
    }

}