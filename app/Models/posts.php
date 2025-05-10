<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
    protected $table = "posts";

    protected  $fillable = ["title", "image_url", "short_description", "content", "created_by", "updated_by"];

    public function comments()
    {
        return $this->hasMany(comments::class, 'posts_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
