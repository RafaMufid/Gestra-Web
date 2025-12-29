<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gesture_name',
        'accuracy',
        'source',
    ];

    public function user()
    {
        return $this->belongsTo(UserData::class, 'user_id');
    }
}
