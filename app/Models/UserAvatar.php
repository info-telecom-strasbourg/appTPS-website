<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAvatar extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = [
        'name',
        'path',
        'size',
        'user_id',
        'is_default'
    ];

    protected $casts = [
        'is_default'=> 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
