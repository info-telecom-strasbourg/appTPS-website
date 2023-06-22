<?php

namespace App\Models\Bde;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $connection = 'bde_bdd';

    protected $fillable = [
        'type'
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
