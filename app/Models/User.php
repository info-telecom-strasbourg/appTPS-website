<?php

namespace App\Models;

use App\Models\Bde\Organization;
use App\Models\Bde\OrganizationMember;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Post;
use App\Models\Reaction;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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
        'promotion_year',
        'sector_id',
        'birth_date'
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

    public function sector(){
        return $this->belongsTo(Sector::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function comments(){
        return $this->hasMany(PostComment::class);
    }

    public function reactions(){
        return $this->hasMany(Reaction::class);
    }

    public function organizations(){
        return $this->belongsToMany(Organization::class,
                'organization_members',
                'member_id',
                'organization_id',
                'bde_id')
            ->withPivot('role');
    }

    public function isInOrganization($organization_id){
        return $this->organizations()->where('organization_id', $organization_id)->exists();
    }

    public function avatar(){
        return $this->hasOne(UserAvatar::class)->withDefault([
            'name' => 'default.png',
            'path' => asset('storage/images/avatars/default.png'),
            'size' => 0,
            'user_id' => $this->id
        ]);
    }

    public function getFullName(){
        return $this->first_name . ' ' . $this->last_name;
    }

}
