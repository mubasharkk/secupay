<?php

namespace App\Models;

use App\Models\Scopes\ZeitraumScope;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Ramsey\Uuid\Uuid;

class ApiKey extends Model
{
    protected $table = 'api_apikey';

    protected $fillable = [
        'apiKey',
        'vertrag_id',
        'zeitraum_id',
        'ist_masterkey',
        'beartbeiter_id',
        'timestamp'
    ];

    protected $casts = [
        'timestamp' => \Carbon\Carbon::class
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ZeitraumScope);
    }
}
