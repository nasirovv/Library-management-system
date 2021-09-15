<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    private $upload_path = '/app/public/image_uploads/';

    private $pattern = '*.{png,jpeg,gif,jpg}';

    public function upload($image, $catalog, $id)
    {
        try {
            Storage::putFileAs(
                "public/image_uploads/{$catalog}/{$id}",
                $image,
                $this->createName($image)
            );
        } catch (Exception $e) {
            Log::alert("Unable to upload image. {$e->getMessage()}");
        }
    }

    public function update($image, $catalog, $id)
    {
        $this->removeAllFilesFromDirectory($this->path($catalog, $id));
        $this->upload($image, $catalog, $id);
    }

    public function get($catalog, $id)
    {
        $images = glob($this->path($catalog, $id) . '/' . $this->pattern, GLOB_BRACE);

        if (empty($images)) {
            return null;
        }

        $first_image = basename($images[0]);

        return url('/') . Storage::url("image_uploads/{$catalog}/{$id}/{$first_image}");
    }

    protected function path($catalog, $id)
    {
        return storage_path() . $this->upload_path . $catalog . '/' . $id;
    }

    protected function createName($image)
    {
        $extension = $image->getClientOriginalExtension();

        return date('dmYHi') . '.' . $extension;
    }

    protected function removeAllFilesFromDirectory($path)
    {
        $images = glob($path . '/*', GLOB_BRACE);

//        if (empty($images)) {
//            throw new Exception('Directory is empty!');
//        }

        foreach ($images as $image) {
            if (is_file($image)) {
                unlink($image);
            }
        }
    }
}

