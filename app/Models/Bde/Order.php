<?php

namespace App\Models\Bde;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $connection = 'bde_bdd';

    public $timestamps = false;

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

    public function getActualBalance($balance){
        if ($this->product != null){
            return $balance + $this->price;
        } else {
            return $balance - $this->price;
        }
    }
}
