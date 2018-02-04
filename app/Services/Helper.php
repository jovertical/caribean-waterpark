<?php

namespace App\Services;

use Str, Carbon;

class Helper {

    public static function create_filename($ext) {
        return Carbon::now()->format('Y_m_d_His') . '_' . str_random(25) . '.' . $ext;
    }
}