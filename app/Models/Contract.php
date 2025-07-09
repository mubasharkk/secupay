<?php

namespace App\Models;

use App\Models\Scopes\ZeitraumScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contract extends Model
{
    protected $table = 'vertragsverw_vertrag';

    protected $primaryKey = 'vertrag_id';

    protected $fillable = [
        'zeitraum_id',
        'nutzer_id',
        'Bearbeiter',
        'erstelldatum',
        'timestamp',
    ];

    protected $casts = [
        'erstelldatum' => 'date',
        'timestamp'    => 'datetime'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ZeitraumScope);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nutzer_id', 'nutzerdetails_id');
    }

}
