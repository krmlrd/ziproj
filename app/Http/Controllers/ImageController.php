<?php

namespace App\Http\Controllers;

use App\Image;
use Storage;
use Auth;

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
        $images = $request->images;

        foreach($images as $image) {
            $imagePath = Storage::disk('uploads')->put($user->id . '/images/', $image);
            Image::create([
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

        $image = Image::find($imageId);
        if ($image) {
          $image->delete();

          return response()->noContent();
        } else {
          return response()->json(['success' => false], 404);
        }
    }
}
