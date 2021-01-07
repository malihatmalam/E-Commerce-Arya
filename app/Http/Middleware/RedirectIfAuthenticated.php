<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // Dikarenakan menggunakan prefix administrator, maka redirect bukan ke /home tapi ke /administrator/home
        if (Auth::guard($guard)->check()) {
            return redirect('/administrator/home');
        }

        return $next($request);
    }
}
