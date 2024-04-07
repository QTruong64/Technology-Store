<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function PostTagToTag()
    {
        return $this->belongsTo('App\Models\Tag', 'tag_id', 'id');
    }
    public function PostTagToPost()
    {
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }
}