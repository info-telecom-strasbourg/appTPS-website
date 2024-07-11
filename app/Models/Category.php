<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    public $timestamps = false;

    public $fillable = [
        'category_type_id',
        'post_id',
        'event_id'
    ];

    public function categoryType(){
        return $this->belongsTo(CategoryType::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }

}
