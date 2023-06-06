<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'id_user',
        'email',
        'content',
        'asso_club',
        'file',
        'is_delete'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
