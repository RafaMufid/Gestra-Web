<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    public function comments()
    {
        return $this->hasMany(Comment::class, 'community_post_id')->latest();
    }
    use HasFactory;
    protected $table = 'community_posts';
    protected $fillable = [
        'title',
        'author',
        'content',
        'likes',
        'topic',
    ];
}
