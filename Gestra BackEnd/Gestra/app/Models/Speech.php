<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speech extends Model
{
    use HasFactory;

    protected $table = 'speech_results';

    protected $fillable = [
        'user_id',
        'text',
        'duration',
    ];
}