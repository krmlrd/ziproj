<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'user_id'];

    public function author()
    {
        return $this->belonsTo('App\User');
    }

    public function images()
    {
      return $this->hasMany('App\Image');
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function($post) {
            $post->images()->each(function($image) {
                $image->delete();
            });
        });
    }
}
