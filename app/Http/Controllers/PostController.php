<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Image;
use Auth;
use Storage;

class PostController extends Controller
{
    public function getAllPosts()
    {
        $posts = Post::with('images')->orderBy('created_at', 'desc')->get();

        return response()->json(['success' => true, 'data' => $posts]);
    }

    public function createPost(Request $request)
    {
        $user = Auth::user();
        $title = $request->title;
        $body = $request->body;
        $images = $request->images;

        $post = Post::create([
            'title' => $title,
            'body' => $body,
            'user_id' => $user->id,
        ]);

        foreach($images as $image) {
            // $imagePath = Storage::disk('uploads')->put($user->id . '/posts/' . $post->id, $image);
            // Image::create([
            //     'image_caption' => $title,
            //     'image_path' => '/uploads/' . $imagePath,
            //     'user_id' => $user->id,
            //     'post_id' => $post->id,
            // ]);
        }

        return response()->json(['success' => true, 'data' => $post]);
    }

    public function deletePost(Request $request)
    {
        $user = Auth::user();
        $postId = $request->id;

        $post = Post::find($postId);
        if ($post) {
          $post->delete();

          return response()->noContent();
        } else {
          return response()->json(['success' => false], 404);
        }
    }
}
