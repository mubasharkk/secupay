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

        $accessToken = $request->bearerToken();

        if (!$accessToken) {
            throw new AuthenticationError('Access token required to access this endpoint.', Response::HTTP_UNAUTHORIZED);
        }


        if (!$service->authenticate($accessToken)) {
            throw new AuthenticationError('Invalid API key provided.', Response::HTTP_UNAUTHORIZED);
        }

        $apiKey = $service->getApiKey($accessToken);

        $request->{'user'} = $apiKey->user;

        return $next($request);
    }
}
