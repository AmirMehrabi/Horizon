<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubdomainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $baseDomain = config('subdomains.base_domain');
        
        // Extract subdomain
        $subdomain = null;
        if (str_contains($host, '.')) {
            $parts = explode('.', $host);
            if (count($parts) > 1 && $parts[1] === explode('.', $baseDomain)[0]) {
                $subdomain = $parts[0];
            }
        }
        
        // Set subdomain in request for use in controllers/views
        $request->attributes->set('subdomain', $subdomain);
        
        return $next($request);
    }
}
