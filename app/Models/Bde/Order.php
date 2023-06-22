<?php

namespace App\Models\Bde;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $connection = 'bde_bdd';

    protected $fillable = [
        'product_id',
        'member_id',
        'price',
        'amount',
        'date'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function member(){
        return $this->belongsTo(Member::class);
    }
}
