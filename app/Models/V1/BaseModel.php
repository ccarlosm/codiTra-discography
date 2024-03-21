<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $appends = ['object_type'];

    public function getObjectTypeAttribute()
    {
        return self::getTableName();
    }

    public static function getTableName()
    {
        return (new static)->getTable();
    }

    public static function boot()
    {
        parent::boot();
        /**
         * Prevents lazy loading in production
         * Throws errors in development to prevent performance issues with lazy loading
         */
        Model::preventLazyLoading(! app()->isProduction());

        /**
         * This is a global event listener for lazy loading
         * This could be used in production
         */
        Model::handleLazyLoadingViolationUsing(function ($model, $relation) {
            //This could be used in production
            //Send email or whatever we want to do
        });
    }
}
