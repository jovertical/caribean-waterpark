<?php

namespace App\Services;

use Str, Carbon, File, Storage, Image, URL;

class ImageUploader {

    public static function upload($file, $path) {
        $ext = $file->getClientOriginalExtension();
        $file_name = Helper::create_filename($ext);
        $thumbnail = ['height' => 500, 'width' => 500];

        $base_path = "public/{$path}";

        $file->storeAs($base_path, $file_name);

        // if (in_array($ext, ['jpg', 'png', 'jpeg', 'gif'])) {
        //     Image::make("{$base_path}/{$file_name}")
        //         ->crop($thumbnail['width'], $thumbnail['height'])
        //         ->save("{$thumbs_path}/{$file_name}", 95);
        // }

        return ['file_path' => $base_path, 'file_name' => $file_name];
    }
}