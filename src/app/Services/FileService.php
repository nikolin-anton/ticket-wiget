<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

class FileService
{
    public function upload(Model $model, array $files, string $collection)
    {
        foreach ($files as $file) {
            $model->addMedia($file)
                ->toMediaCollection($collection);
        }
    }

    public function getFiles(Model $model, string $collection)
    {
        return $model->getMedia($collection);
    }

    public function download(Media $media)
    {
        return response()->download(
            $media->getPath(),
            $media->file_name
        );
    }

    public function downloadAllFille(Model $model, string $collection)
    {
        $downloads = $model->getMedia($collection);

        return MediaStream::create('files.zip')->addMedia($downloads);
    }
}
