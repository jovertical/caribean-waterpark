<?php

namespace App\Services;

use Str, Carbon, File, Storage, Image, URL;

class ImageUploader {

    public static function upload($file, $directory) {
        $file_ext = $file->getClientOriginalExtension();
        $file_name = Helper::create_filename($file_ext);
        $thumbnail = ['height' => 500, 'width' => 500];

        $base_directory = "public/{$directory}";
        $thumbs_directory = "{$base_directory}/thumbnails";

        $path = $file->storeAs($base_directory, $file_name);

        if (! Storage::exists($base_directory)) {
            Storage::makeDirectory($base_directory, $mode = 0777, true, true);
        }

        if (! Storage::exists($thumbs_directory)) {
            Storage::makeDirectory($thumbs_directory, $mode = 0777, true, true);
        }

        if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            Image::make(Storage::get("{$base_directory}/{$file_name}"))
                ->crop($thumbnail['width'], $thumbnail['height'])
                ->save(storage_path("app/{$thumbs_directory}/{$file_name}", 95));
        }

        return [
            'file_path' => URL::to(Storage::url($path)),
            'file_directory' => URL::to(Storage::url($base_directory)),
            'file_name' => $file_name
        ];
    }
}