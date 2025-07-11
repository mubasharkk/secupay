<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flagbit extends Model
{
    protected $table = 'vorgaben_flagbit';

    protected $fillable = [
        'beschreibung',
        'tabellen'
    ];
}
