<?php

namespace App\Services;

use Illuminate\Pagination\{Paginator, LengthAwarePaginator};
use Str, URL;
use Carbon;

class Helper {

    public static function createFilename($ext)
    {
        $name = str_random(25);

        return  "{$name}.{$ext}";
    }

    public static function createLoginCredential($email)
    {
        return substr($email, 0, strrpos($email, '@'));
    }

    public static function createRandomToken()
    {
        $key = config('app.key');

        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        return hash_hmac('sha256', Str::random(40), $key);
    }

    public static function createPaddedCounter($counter)
    {
        $length = strlen($counter);

        return str_pad($counter, $length > 4 ? $length : 4, '0', STR_PAD_LEFT);
    }

    public static function activeMenu($segment_2)
    {
        $segments = [
            'inventory'     => ['categories', 'items', 'coupons'],
            'reservations'  => ['reservations'],
            'manage'        => ['users', 'superusers', 'user-roles', 'settings'],

            'reservation'   => ['search', 'user', 'review']
        ];

        foreach ($segments as $index => $segment) {
            if (in_array($segment_2, array_values($segment))) {
                return $index;
            }
        }

        return;
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

    public static function moneyFormat(float $amount)
    {
        return number_format($amount, 2, '.', ',');
    }

    public static function moneyString(float $amount, $currency_sign = '₱')
    {
        return $currency_sign.number_format($amount, 2, '.', ',');
    }

    public static function searchRequestUrl(array $search_parameters)
    {
        $input_with_values = [];

        foreach ($search_parameters as $index => $search_parameter) {
            $input_with_values[] = $index.'='.$search_parameter;
        }

        return url()->current().'?'.implode('&', $input_with_values);
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