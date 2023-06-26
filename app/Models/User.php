<?php

namespace App\Models;

use App\Models\Bde\Organization;
use App\Models\Bde\OrganizationMember;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Post;
use App\Models\Reaction;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'email',
        'password',
        'phone',
        'user_name',
        'bde_id',
        'avatar',
        'promotion_year'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function reactions(){
        return $this->hasMany(Reaction::class);
    }

    public function organization_roles(){
        return $this->hasMany(OrganizationMember::class, 'member_id');
    }

    public function getAvatarPath(){
        return asset('storage/images/avatars/'.$this->avatar);
    }

    public function getFullName(){
        return $this->first_name . ' ' . $this->last_name;
    }
}
