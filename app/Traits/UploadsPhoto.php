<?php

namespace  App\Traits;

trait UploadsPhoto
{
    function uploadPhoto($request, $field, $model, $collection)
    {
        if ($request->has($field)) {
            if ($request->file($field)->isValid()) {
                $disk = config('filesystems.default');
                $path = $request->file($field)->store('', $disk);
                $model->addMediaFromDisk($path, $disk)
                    ->toMediaCollection($collection);
            }
        }
    }
}
