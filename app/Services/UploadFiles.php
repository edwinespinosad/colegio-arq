<?php

namespace App\Services;

class UploadFiles
{
    public static function storeFile($file, $id, $pathType = ''): string
    {
        $path = '/uploads/' . $pathType;
        $name = 'colegio_' . str_replace('.', '',
                (string)microtime(true)) . '_' . $id . '.' . $file->extension();

        // Create path if does not exists
        if (!file_exists(public_path() . $path)) {
            mkdir(
                public_path() . $path,
                0777,
                true
            );
        }

        // Move image to corresponding directory
        $file->move(public_path() . $path, $name);
        return $path . '/' . $name;
    }


    public static function deleteFile($path): void
    {
        $path = public_path() . $path;
        if (\File::exists($path)) \File::delete($path);
        return;
    }
}
