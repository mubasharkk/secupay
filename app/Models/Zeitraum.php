<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Zeitraum extends Model
{
    protected $table = 'vorgaben_zeitraum';

    protected $primaryKey = 'zeitraum_id';

    protected $fillable = [
        'von',
        'bis'
    ];

    protected $casts = [
        'von' => Carbon::class,
        'bis' => Carbon::class
    ];
}
