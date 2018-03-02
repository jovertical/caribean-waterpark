<?php

namespace App;

use Illuminate\Support\Facades\Schema;
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
            if (Schema::hasColumn($model->getTable(), 'slug')) {
                $model->slug = str_random(20);
            }

            if ($user != null) {
                if (Schema::hasColumn($model->getTable(), 'created_by')) {
                    $model->created_by = $user->id;
                }
            }
        });

        self::updating(function($model) use ($user) {
            if ($user != null) {
                if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                    $model->updated_by = $user->id;
                }
            }
        });

        self::deleting(function($model) use ($user) {
            if ($user != null) {
                if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                    $model->updated_by = $user->id;
                }
            }
        });
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}