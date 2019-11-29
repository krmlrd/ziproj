<?php

namespace App\Http\Controllers;

use App\Image;
use Storage;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function getAllImages()
    {
        $images = Image::all();

        return response()->json(['success' => true, 'data' => $images]);
    }

    public function createImage(Request $request)
    {
        $user = Auth::user();
        $title = $request->title;
        $images = $request->images;

        foreach($images as $image) {
            $imagePath = Storage::disk('uploads')->put($user->id . '/images/' . $image);
            Image::create([
                'image_caption' => $title,
                'image_path' => '/uploads/' . $imagePath,
                'user_id' => $user->id,
            ]);
        }

        return response()->json(['success' => true, 'data' => $images]);
    }

    public function deleteImage(Request $request)
    {
        $user = Auth::user();
        $imageId = $request->id;

        $post = Image::find($imageId);
        if ($imageId) {
          $imageId->delete();

          return response()->noContent();
        } else {
          return response()->json(['success' => false], 404);
        }
    }
}
