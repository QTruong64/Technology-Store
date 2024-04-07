<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'public_id';
    }
    public function getRouteKey()
    {
        return str()->slug($this->name) . '-' . $this->getAttribute($this->getRouteKeyName());
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $id = last(explode('-', $value));
        $model = parent::resolveRouteBinding($id, $field);

        if (!$model || $model->getRouteKey() === $value) {
            return $model;
        }

        throw new HttpResponseException(
            redirect()->route('post.show', $model)
        );
    }

    public function PostToUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function PostToPostTags()
    {
        return $this->hasMany('App\Models\PostTag', 'post_id', 'id');
    }
}
