<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToCompany
{
    protected static function bootBelongsToCompany()
    {
        static::creating(function ($model) {
            if (Auth::check() && empty($model->company_id)) {
                $model->company_id = Auth::user()->company_id;
            }
        });

        static::addGlobalScope('company', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where(
                    $builder->getModel()->getTable() . '.company_id',
                    Auth::user()->company_id
                );
            }
        });
    }
}
