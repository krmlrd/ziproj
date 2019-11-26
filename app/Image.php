<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Image extends Model
{
    protected $fillable = ['post_id', 'user_id', 'image_path', 'image_caption'];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function author()
    {
        return $this->belongsTo('App\User');
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function($image) {
            $path = $image->image_path;
            $path = str_replace('/uploads/', '', $image->image_path);
            if(Storage::disk('uploads')->exists($path)) {
                Storage::disk('uploads')->delete($path);
            }
        });
    }
}
