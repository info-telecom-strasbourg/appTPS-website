<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserAvatar extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = [
        'name',
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

    public function getUrl()
    {
        $disk = 'avatars';

        if ($this->is_default) {
            return Storage::disk($disk)->url("defaults/" . $this->name);
        }
        return Storage::disk($disk)->url($this->name);
    }
}
