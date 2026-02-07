<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\UserType;

class EnsureUserIsTourLeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user || $user->type !== UserType::REPRESENTATIVE) {
            return response()->json([
                'message' => 'Unauthorized — REPRESENTATIVE only'
            ], 403);
        }

        return $next($request);
    }
}
