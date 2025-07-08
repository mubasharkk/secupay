<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Zeittraum extends Model
{

    protected $table = 'vorgaben_zeitraum';

    protected $fillable = [
        'von',
        'bis'
    ];

    protected $casts = [
        'von' => Carbon::class,
        'bis' => Carbon::class
    ];
}
