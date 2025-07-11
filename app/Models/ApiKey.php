<?php

namespace App\Models;

use App\Models\Scopes\ZeitraumScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class ApiKey extends Model
{
    protected $table = 'api_apikey';

    protected $primaryKey = 'apikey_id';

    protected $fillable = [
        'vertrag_id',
        'zeitraum_id',
        'ist_masterkey',
        'bearbeiter_id',
        'timestamp'
    ];

    protected $casts = [
        'timestamp' => 'datetime'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ZeitraumScope());
    }

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            Contract::class,
            'vertrag_id',
            'nutzerdetails_id',
            'vertrag_id',
            'nutzer_id'
        );
    }

    public function contract(): HasOne
    {
        return $this->hasOne(Contract::class, 'vertrag_id', 'vertrags_id');
    }
}
