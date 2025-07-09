<?php

namespace App\Models;

use App\Models\Scopes\ZeitraumScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FlagbitRef extends Model
{
    protected $table = 'stamd_flagbit_ref';


    protected $casts = [
        ''
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ZeitraumScope);
    }

    public function flagbit(): HasOne
    {
        return $this->hasOne(Flagbit::class, 'flagbit', 'flagbit_id');
    }

}
