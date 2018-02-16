<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        $user = auth()->check() ? auth()->user()->id : null;

        self::creating(function ($model) use ($user) {
            $model->created_by = $user;
        });

        self::updating(function($model) use ($user) {
            $model->updated_by = $user;
        });

        self::deleting(function($model) use ($user) {
            $model->deleted_by = $user;
        });
    }
}
