<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->created_by = auth()->check() ? auth()->user()->id : null;
        });

        self::updating(function($model) {
            $model->updated_by = auth()->check() ? auth()->user()->id : null;
        });

        self::deleting(function($model) {
            $model->deleted_by = auth()->check() ? auth()->user()->id : null;
        });
    }
}
