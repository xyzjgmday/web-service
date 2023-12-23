<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = array('title', 'content', 'status', 'user_id');
    public $timestamps = true;

    public function categories()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function comments()
    {
        return $this->belongsToMany('App\Models\Comment');
    }
}