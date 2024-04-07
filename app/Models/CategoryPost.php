<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function TypeToPost()
    {
        return $this->hasMany('App\Models\Post', 'type_id', 'id');
    }
}