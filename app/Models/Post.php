<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Bde\Organization;
use App\Models\Event;
use App\Models\PostMedia;
use App\Models\Category;
use App\Models\Reaction;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization_id',
        'event_id',
        'category_id',
        'title',
        'description',
        'body',
        'color'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function event(){
        return $this->hasMany(Event::class);
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    public function medias(){
        return $this->hasMany(PostMedia::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function reactions(){
        return $this->hasMany(Reaction::class);
    }

    public function comments(){
        return $this->hasMany(PostComment::class);
    }
}
