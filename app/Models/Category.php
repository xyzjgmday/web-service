<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Table database
     */
    protected $table = 'categories';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function post()
    {
        return $this->belongsToMany('App\Post', 'categories_id');
    }
}
