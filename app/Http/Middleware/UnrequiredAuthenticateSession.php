<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Http\Middleware\AuthenticateSession;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class UnrequiredAuthenticateSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $request = app(EnsureFrontendRequestsAreStateful::class)->handle($request, $next);
            $request = app(AuthenticateSession::class)->handle($request, $next);
        }
        return $next($request);
    }
}
