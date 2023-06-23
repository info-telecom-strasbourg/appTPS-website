<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    protected $table = 'post_comments';

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_comment_id',
        'body',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
