<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
trait ImageUpload
{

    public function uploadImage($image, $folder = 'uploads')
    {
        if ($image && $image->isValid()) {
            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            return $image->storeAs($folder, $filename, 'public');
        }

        return null;
    }


    public function deleteImage($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->delete($filePath);
        }

        return false; // Return false if the file doesn't exist
    }

}