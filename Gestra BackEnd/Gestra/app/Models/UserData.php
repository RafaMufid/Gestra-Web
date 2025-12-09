<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserData extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user_data';

    protected $fillable = [
        'username',
        'email',
        'password',
        'user_type',
        'profile_photo_path'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
