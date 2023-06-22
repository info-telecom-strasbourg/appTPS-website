<?php

namespace App\Models\Bde;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $connection = 'bde_bdd';

    protected $fillable = [
        'name',
        'title',
        'price',
        'product_type_id',
        'color'
    ];
}
