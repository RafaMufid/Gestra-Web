<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class UserData extends Model
{

    use HasApiTokens;

    protected $table = 'user_data';

    protected $fillable = [
        'username',
        'email',
        'password',
        'user_type',
        'photo'
    ];

    protected $hidden = [
        'password',
    ];
}
