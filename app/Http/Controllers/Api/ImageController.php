<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ImageController extends Controller
{
    //

    public function store(): JsonResponse
    {
        // validate incoming file
        $validated = Validator::make(request()->all(), [
            'post_attachment' => [
                'required',
                'file',
                'image',
                'mimes:png,jpg,jpeg',
                'max:2048'
            ]
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors()->messages(), 400);
        }

        $file = request()->file('post_attachment')->store('post_attachments', 'public');

        return response()->json([
            'link' => Str::of($file)->prepend(request()->getSchemeAndHttpHost() . '/'),
        ], 201);
    }

    private function cleanUpImageName(?string $image): string
    {
        if (is_null($image)) return '';

        // removing host and port from the image name
        return Str::of($image)->remove(request()->getSchemeAndHttpHost() . '/');
    }

    public function destroy(): JsonResponse
    {
        foreach (request()->input('srcs') as $image) {
            $img    = $this->cleanUpImageName($image);
            $errors = [];

            // check if image is exists in the storage
            if (Storage::disk('public')->exists($img)) {

                try {
                    Storage::disk('public')->delete($img);
                } catch (Throwable $e) {
                    $errors[] = $e->getMessage();
                }
            } else {
                $errors[] = "Image {$img} is not found!";
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
