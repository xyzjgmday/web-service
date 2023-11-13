<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    // Post -> table-name = posts
    // custome table name :
    // protected $table='table_name'

    // Definisikan nama kolom
    protected $fillable = array ('title', 'content', 'status', 'user_id');
}

?>