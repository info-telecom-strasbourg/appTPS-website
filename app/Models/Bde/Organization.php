<?php

namespace App\Models\Bde;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class Organization extends Model
{
    use HasFactory;

    protected $connection = 'bde_bdd';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'acronym',
        'description',
        'website_link',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'discord_link',
        'email',
        'association'
    ];

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function events(){
        return $this->hasMany(Event::class);
    }

    public function members(){
        return $this->belongsToMany(Member::class,
            'organization_members',
            'organization_id',
            'member_id',
            'id')
            ->using(OrganizationMember::class)
            ->withPivot('role');
    }

    public function scopeFilter($query, $filters){
        $query->when($filters['search'] ?? null, function($query, $search){
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('short_name', 'like', '%' . $search . '%');
        });
    }
    public function logo(){
        return $this->hasOne(OrganizationLogo::class)->withDefault([
            'name' => 'default.png',
            'path' => env('FOUAILLE_URL').'/storage/images/organization_logo/default.png',
            'size' => 0,
            'organization_id' => $this->id
        ]);
    }

    public function getLogoPath(){
        return $this->logo->path;
    }

}
