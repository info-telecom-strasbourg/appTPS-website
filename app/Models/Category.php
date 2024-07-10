<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'post_categories';

    public $timestamps = false;

    public function categoryType(){
        return $this->belongsTo(CategoryType::class);
    }
}
