<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
		if (Auth::guard($guard)->check()) {
			switch ($guard) {
				case 'admin':
					return redirect('/admin/index');
					break;
				default:
					return redirect('/');
					break;
			}
		}
        return $next($request);
    }
}
