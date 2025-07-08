<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
