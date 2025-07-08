<?php

namespace App\Services;

use App\Models\ApiKey;

class AuthenticatorService
{
    public function authenticate(string $apiKey): bool
    {
        return ApiKey::where('apikey', $apiKey)->exists();
    }
}
