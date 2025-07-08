<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthenticationError;
use App\Services\AuthenticatorService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $service = app(AuthenticatorService::class);

        if (!$service->authenticate($request->get('access_token'))) {
            throw new AuthenticationError('Invalid API key provided.', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
