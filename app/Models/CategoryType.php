<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{

    use HasFactory;

    protected $table = 'category_types';

    public $timestamps = false;

    public function categories(){
        return $this->hasMany(Category::class);
    }

    public function scopeFilter($query, $filters){
        $query->when($filters['search'] ?? null, function($query, $search){
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
}
