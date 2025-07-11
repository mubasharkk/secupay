<?php

namespace App\Services;

use App\Models\ApiKey;
use Illuminate\Support\Carbon;

class AuthenticatorService
{
    public function authenticate(string $apiKey, bool $onlyMasterKey = false): bool
    {
        $currentTime = Carbon::now();

        $query = ApiKey::where('apikey', $apiKey)
            ->where('von', '<=', $currentTime)
            ->where('bis', '>=', $currentTime);

        if ($onlyMasterKey) {
            $query = $query->where(['ist_masterkey' => 1]);
        }

        return $query->exists();
    }

    public function getApikey(string $apiKey): ?ApiKey
    {
        return ApiKey::where('apikey', $apiKey)->with('user')->first();
    }

}
