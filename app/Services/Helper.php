<?php

namespace App\Services;

use Illuminate\Pagination\{Paginator, LengthAwarePaginator};
use Str, URL;
use Carbon;

class Helper {

    public static function create_filename($ext)
    {
        $name = str_random(25);

        return  "{$name}.{$ext}";
    }

    public static function fileUrl($data, $type = '')
    {
        if (is_object($data)) {
            if (($data->file_directory != null) && ($data->file_name != null)) {
                switch ($type) {
                    case 'thumbnail':
                            $file_url = URL::to("{$data->file_directory}/thumbnails/{$data->file_name}");
                        break;

                    default:
                            $file_url = URL::to("{$data->file_directory}/{$data->file_name}");
                        break;
                }

                return $file_url;
            }
        }

        return '/root/assets/app/media/img/misc/noimage.png';
    }

    public static function paginate($data, $perPage = 10)
    {
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