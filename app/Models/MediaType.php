<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PostMedia;

class MediaType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'type'
    ];

    public function medias(){
        return $this->hasMany(PostMedia::class);
    }
}
