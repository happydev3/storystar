<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\BlockedIpAddress;

class BlockIP
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
        $blocked_ip_address = BlockedIpAddress::where('ip_address','LIKE',$request->getClientIp())->count();
        if($blocked_ip_address > 0){
            abort(404);
        }
        else{
            return $next($request);
        }
    }
}
