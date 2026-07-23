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

    public function getUrl()
    {
        $disk = config('avatar.disk');

        if ($this->is_default) {
            $directory = config('avatar.defaults_directory');
            return Storage::disk($disk)->url($directory . "/" . $this->name);
        }
        $directory = config('avatar.directory');
        return Storage::disk($disk)->url($directory . "/" . $this->name);
    }
}
