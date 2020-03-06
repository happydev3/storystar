<?php

namespace App\Http\Middleware;
use Cache;
use Closure;

class AfterNoCache
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('Cache-Control','no-store, nocache, max-age=0, must-revalidate, post-check=0, pre-check=0');
        $response->headers->set('Pragma','no-cache');
        $response->headers->set('Expires','Sat, 26 Jul 1997 05:00:00 GMT');
        return $response;
    }
}
