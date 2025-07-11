<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Transaction extends Model
{
    protected $table = 'transaktion_transaktionen';

    protected $primaryKey = 'trans_id';


    public function contract(): HasOne
    {
        return $this->hasOne(Contract::class, 'vertrag_id', 'vertrag_id');
    }

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            Contract::class,
            'nutzer_id',
            'nutzerdetails_id',
            'vertrag_id',
            'vertrag_id'
        );
    }
}
