<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization_id',
        'event_id',
        'title',
        'description',
        'summary',
        'location',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function event(){
        return $this->hasMany(Event::class);
    }
}
