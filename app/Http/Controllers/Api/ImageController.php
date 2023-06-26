<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\FileUploader;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ImageController extends Controller
{
    use FileUploader;

    public function store(): JsonResponse
    {
        $attachment = request()->query('type') === 'ckeditor' ? 'upload' : 'post_attachment';
        // validate incoming file
        $validated = Validator::make(request()->all(), [
            $attachment => [
                'required',
                'file',
                'image',
                'mimes:png,jpg,jpeg',
                'max:2048'
            ]
        ]);

        // send validator fails message
        if ($validated->fails()) {
            return response()->json($validated->errors()->messages(), 400);
        }
        try {
            $upload = $this->uploadFile($attachment);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        $response = request()->query('type') === 'ckeditor' ? [
            'fileName' => $upload['url'],
            'uploaded' => 1,
            'url'      => $upload['url']
        ] : [
            'link' => $upload['url']
        ];
        return response()->json($response, 201);
    }

    private function cleanUpImageName(?string $image): string
    {
        if (is_null($image)) return '';

        if ($this->getStorageDriver() === 's3') return $image;

        // removing host and port from the image name
        return Str::of($image)->remove(request()->getSchemeAndHttpHost() . '/');
    }

    public function destroy(): JsonResponse
    {
        foreach (request()->input('srcs') as $image) {
            $img    = $this->cleanUpImageName($image);
            $errors = [];

            // check if image is exists in the storage
            try {
                $this->deleteUploadedFile($img);
            } catch (Throwable $e) {
                $errors[] = $e->getMessage();
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'status' => false,
                'messages' => $errors,
            ], 400);
        }

        return response()->json([
            'status'  => true,
            'messages' => 'Images deleted successfully!',
        ]);
    }
}
