<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UploadImageTrait
{
    public function uploadImage($request, $fieldName, $folderName)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->$fieldName;
            $fileName = Str::random(20) . '-' . $file->getClientOriginalName();
            $filePath = $file->move('public/uploads/' . $folderName, $fileName);

            return $filePath;
        }
        return null;
    }
}
