<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'user_id',
        'post_comment_id',
        'reaction_type_id'
    ];

    public function reactionType()
    {
        return $this->belongsTo(ReactionType::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function postComment()
    {
        return $this->belongsTo(PostComment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
