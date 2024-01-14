<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Urls;

class RequestGuardian
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userIp = $request->ip();
        $now = now();
        $tenMinutesAgo = $now->subMinutes(10);
        $thirtyRequests = Urls::where('user_ip', $userIp)
            ->where('created_at', '>=', $tenMinutesAgo)
            ->count();
        if ($thirtyRequests >= 20) {
            return response()->json([
                'error' => 'Muitas requisições',
            ], 429);
        }
        return $next($request);
    }
}
