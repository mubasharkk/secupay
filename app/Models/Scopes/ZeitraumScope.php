<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ZeitraumScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->leftJoin(
            'vorgaben_zeitraum',
            'vorgaben_zeitraum.zeitraum_id',
            '=',
            $model->getTable() . '.zeitraum_id'
        );
    }
}
