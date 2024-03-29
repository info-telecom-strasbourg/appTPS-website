<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAvatar extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'size',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
