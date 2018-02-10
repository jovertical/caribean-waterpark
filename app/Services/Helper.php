<?php

namespace App\Services;

use Str, Carbon;

class Helper {

    public static function create_filename($ext) {
        $name = str_random(25);

        return  "{$name}.{$ext}";
    }
}