<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminReserved
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array(UserRole::ADMIN, $request->user()->roles->toArray(), true)) {
            return back(fallback: route('dashboard'))
                ->with('error', 'La page demandée est réservée aux administrateurs.');
        }

        return $next($request);
    }
}
