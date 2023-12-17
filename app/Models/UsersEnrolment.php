<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersEnrolment extends Model
{
    /**
     * Table database
     */
    protected $table = 'users_enrolment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['users_id', 'role_id'];
}
