<?php

namespace App\Traits;

use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileUploader
{
    public function getStorageDriver(): string
    {
        return Storage::getDefaultDriver();
    }

    public function uploadFile($fileRequestName, $location = 'post_attachments'): array
    {


        try {
            $fileRequest = request()->file($fileRequestName);
            if (is_null($fileRequest)) throw new Exception('File not found!');

            $file  = $fileRequest->store($location);
            $link  =  $this->getUploadedFile($file);

            if ($this->getStorageDriver() === 'local') {
                $file = $fileRequest->store($location, 'public');
                $link = $this->buildLocalFileName($file);
            }
        } catch (Exception $e) {
            throw new Exception("Failed to upload the file, reason: {$e->getMessage()}");
        }

        return [
            'fileName' => $file,
            'url'  => $link,
        ];
    }

    public function getUploadedFile($file): string
    {
        if (!Storage::exists($file)) {
            throw new Exception('File not found!');
        }

        $ttl = now()->addHour();
        Cache::put('image_' . $file, Storage::temporaryUrl($file, $ttl), $ttl);
        return Cache::get('image_' . $file) ?? $file;
    }

    public function buildLocalFileName(string $fileName): string
    {
        return Str::of($fileName)->prepend(request()->getSchemeAndHttpHost() . '/');
    }

    public function getStorageClass(): Filesystem
    {
        if ($this->getStorageDriver() === 'local') {
            return Storage::disk('public');
        }

        return Storage::disk('s3');
    }

    public function deleteUploadedFile(string $file)
    {
        if ($this->getStorageClass()->exists($file)) {
            throw new Exception('File not found!');
        }

        try {
            return ($this->getStorageClass()->delete($file));
        } catch (Exception $e) {
            throw new Exception("Failed to delete the image, reason: {$e->getMessage()}");
        }
    }
}
