<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = [];
}
