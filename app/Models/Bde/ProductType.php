<?php

namespace App\Models\Bde;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $connection = 'bde_bdd';

    public $timestamps = false;

    protected $fillable = [
        'type'
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
