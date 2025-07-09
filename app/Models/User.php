<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $table = 'stamd_nutzerdetails';

    protected $primaryKey = 'nutzerdetails_id';

    protected $fillable = [
        'name',
        'Bearbeiter',
        'timestamp'
    ];

    protected $casts = [
        'timestamp' => 'datetime'
    ];

    public function apiKeys(): HasMany
    {
        return $this->hasMany(ApiKey::class, 'bearbeiter_id', 'nutzerdetails_id');
    }
}
