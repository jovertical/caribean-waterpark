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

        $user = auth()->check() ? auth()->user() : null;

        self::creating(function ($model) use ($user) {
            $model->slug = str_random(10);
            $model->created_by = $user->id;
        });

        self::updating(function($model) use ($user) {
            $model->updated_by = $user->id;
        });

        self::deleting(function($model) use ($user) {
            $model->deleted_by = $user->id;
        });
    }
}