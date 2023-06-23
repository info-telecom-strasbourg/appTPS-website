<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostMedia extends Model
{
    use HasFactory;

    protected $table = 'post_medias';

    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'media_url',
        'media_type_id'
        ];  
    
    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function mediaType(){
        return $this->belongsTo(mediaType::class);
    }
}
