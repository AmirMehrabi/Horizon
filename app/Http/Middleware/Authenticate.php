<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            $path = $request->getPathInfo();
            
            // Redirect to appropriate login based on path
            if (str_starts_with($path, '/admin')) {
                return route('admin.login');
            } elseif (str_starts_with($path, '/customer')) {
                return route('customer.login');
            } else {
                // Default redirect to portal selection
                return route('choose-portal');
            }
        }

        return null;
    }
}
