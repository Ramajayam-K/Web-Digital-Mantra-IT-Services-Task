<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
    protected $table = "posts";

    protected  $fillable = ["title", "image_url", "short_description", "content"];

    public function comments()
    {
        return $this->hasMany(comments::class, 'posts_id');
    }
}
