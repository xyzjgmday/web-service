<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * Table database
     */
    protected $table = 'profile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'no_telp', 'alamat', 'tempat_lahir', 'tgl_lahir', 'bio', 'pp', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
