<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    protected static function getPublicPath($path)
    {
        $fullPath = public_path('assets/img/' . $path);

        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        return $fullPath;
    }

    public static function handleUploadedImage($file, $path, $delete = null)
    {
        if ($file) {
            $fullPath = self::getPublicPath($path);

            if ($delete && file_exists($fullPath . '/' . $delete)) {
                unlink($fullPath . '/' . $delete);
            }

            $name = Str::random(4) . $file->getClientOriginalName();
            $file->move($fullPath, $name);

            return $name;
        }
    }

    public static function uploadSummernoteImage($file, $path)
    {
        $fullPath = self::getPublicPath($path);

        if ($file) {
            $name = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move($fullPath, $name);

            return $name;
        }
    }

    public static function ItemhandleUploadedImage($file, $path, $delete = null)
    {
        if ($file) {
            $uploadDir = public_path('assets/img');

            if ($delete && file_exists($uploadDir . '/' . $delete)) {
                unlink($uploadDir . '/' . $delete);
            }

            $photoName = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $thumbnailName = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();

            $file->move($uploadDir, $photoName);

            $image = Image::make($uploadDir . '/' . $photoName)->resize(230, 230);
            $image->save($uploadDir . '/' . $thumbnailName);

            return [$photoName,$thumbnailName];
        }
    }

    public static function handleUpdatedUploadedImage($file, $path, $data, $delete_path, $field)
    {
        $fullPath = self::getPublicPath($path);
        $deleteFullPath = public_path('assets/img/' . $delete_path);

        $name = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move($fullPath, $name);

        if (!empty($data[$field]) && file_exists($deleteFullPath . '/' . $data[$field])) {
            unlink($deleteFullPath . '/' . $data[$field]);
        }

        return $name;
    }

    public static function ItemhandleUpdatedUploadedImage($file, $path, $data, $delete_path, $field)
    {
        $fullPath = self::getPublicPath($path);
        $deleteFullPath = public_path('assets/img/' . $delete_path);

        $photoName = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $thumbnailName = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();

        $image = Image::make($file)->resize(230, 230);
        $image->save($fullPath . '/' . $thumbnailName);

        $file->move($fullPath, $photoName);

        if (!empty($data['thumbnail']) && file_exists($deleteFullPath . '/' . $data['thumbnail'])) {
            unlink($deleteFullPath . '/' . $data['thumbnail']);
        }

        if (!empty($data[$field]) && file_exists($deleteFullPath . '/' . $data[$field])) {
            unlink($deleteFullPath . '/' . $data[$field]);
        }

        return [$photoName, $thumbnailName];
    }

    public static function handleDeletedImage($data, $field, $delete_path)
    {
        $deleteFullPath = public_path('assets/img/' . $delete_path);

        if (!empty($data[$field]) && file_exists($deleteFullPath . '/' . $data[$field])) {
            unlink($deleteFullPath . '/' . $data[$field]);
        }
    }
}
