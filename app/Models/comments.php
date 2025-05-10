<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    protected $table="comments";

    protected  $fillable =["post_id","name","email","message"];

    public function posts(){
        return $this->belongsTo(posts::class,'posts_id');
    }
}
