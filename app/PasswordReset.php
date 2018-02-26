<?php

namespace App;

class PasswordReset extends Model
{
    protected $fillable = [
        'email', 'token',
    ];

    public $timestamps = false;
}