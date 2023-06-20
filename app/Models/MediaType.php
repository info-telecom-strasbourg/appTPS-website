<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mediaType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'type'
    ];

    public function postMedia(){
        return $this->hasMany(PostMedia::class);
    }
}
