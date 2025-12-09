<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Determine redirect based on guard and path
                $path = $request->getPathInfo();
                
                if (str_starts_with($path, '/admin')) {
                    return redirect()->route('admin.dashboard');
                } elseif (str_starts_with($path, '/customer')) {
                    return redirect()->route('customer.dashboard');
                } else {
                    // Default redirect to portal selection
                    return redirect()->route('choose-portal');
                }
            }
        }

        return $next($request);
    }
}
