<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReactionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }   
}
