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
            if (isset($model->slug)) {
                $model->slug = str_random(10);
            }

            if ($user != null) {
                if (isset($model->created_by)) {
                    $model->created_by = $user->id;
                }
            }
        });

        self::updating(function($model) use ($user) {
            if ($user != null) {
                if (isset($model->updated_by)) {
                    $model->updated_by = $user->id;
                }
            }
        });

        self::deleting(function($model) use ($user) {
            if ($user != null) {
                if (isset($model->deleted_by)) {
                    $model->deleted_by = $user->id;
                }
            }
        });
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}