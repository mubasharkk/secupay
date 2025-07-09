<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSetType extends Model
{
    protected $table = 'vorgaben_datensatz_typ';

    protected $primaryKey = 'datensatz_typ_id';

    protected $fillable = [
        'beschreibung',
    ];
}
