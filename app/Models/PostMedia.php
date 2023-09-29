<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Post;
use App\Models\MediaType;

class PostMedia extends Model
{
    use HasFactory;

    protected $table = 'post_medias';

    public $timestamps = false;

    protected $with = ['mediaType'];

    protected $fillable = [
        'post_id',
        'media',
        'media_type_id'
        ];  
    
    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function mediaType(){
        return $this->belongsTo(MediaType::class);
    }
}
