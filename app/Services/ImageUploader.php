<?php

namespace App\Services;

use Str, Carbon, File, Image, URL;

class ImageUploader {

    public static function upload($file, $directory) {
        $ext = $file->getClientOriginalExtension();
        $date_today = Carbon::now()->format('Y_m_d');
        $thumbnail = ['height' => 500, 'width' => 500];

        $path_directory = "{$directory}";
        $resized_directory = "{$directory}/resized";
        $thumbs_directory = "{$directory}/thumbnail";

        if (! File::exists($path_directory)) {
            File::makeDirectory($path_directory, $mode = 0777, true, true);
        }

        if (! File::exists($resized_directory)) {
            File::makeDirectory($resized_directory, $mode = 0777, true, true);
        }

        if (! File::exists($thumbs_directory)) {
            File::makeDirectory($thumbs_directory, $mode = 0777, true, true);
        }

        $file_name = Helper::create_filename($ext);

        $file->move($path_directory, $file_name);

        if (in_array($ext, ['jpg', 'png', 'jpeg', 'gif'])) {
            Image::make("{$path_directory}/{$file_name}")
                ->save("{$resized_directory}/{$file_name}", 95);

            Image::make("{$path_directory}/{$file_name}")
                ->crop($thumbnail['width'], $thumbnail['height'])
                ->save("{$thumbs_directory}/{$file_name}", 95);
        }

        return ['file_path' => URL::to($path_directory), 'file_name' => $file_name]; 
    }
}