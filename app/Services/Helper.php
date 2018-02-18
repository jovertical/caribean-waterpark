<?php

namespace App\Services;

use Illuminate\Pagination\{Paginator, LengthAwarePaginator};
use Str, Carbon;

class Helper {

    public static function create_filename($ext) {
        $name = str_random(25);

        return  "{$name}.{$ext}";
    }

    public static function paginate($data, $perPage = 10) {
        if (is_array($data)) {
            $data = collect($data);
        }

        return new LengthAwarePaginator(
            $data->forPage(Paginator::resolveCurrentPage(), $perPage),
            $data->count(), $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
    }
}