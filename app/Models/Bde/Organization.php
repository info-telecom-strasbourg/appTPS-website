<?php

namespace App\Models\Bde;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\User;

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
        'logo',
        'email',
        'association'
    ];

    public function getLogoPath(){
        if ($this->logo == null) {
            return null;
        }
        return env('FOUAILLE_URL') . 'storage/organization_logo/' . $this->logo;
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function events(){
        return $this->hasMany(Event::class);
    }

    public function users(){
        return $this->belongsToMany(User::class,
            'bdedatapsbs.organization_members',
            'organization_id',
            'member_id',
            'id',
            'bde_id')
            ->using(OrganizationMember::class)
            ->withPivot('role');
    }


    public function scopeOrder($query, $order_by, $order_direction)
    {
        $query->when(isset($order_by, $order_direction), function ($query) use ($order_by, $order_direction) {
            return $query->orderBy($order_by, $order_direction);
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query
                ->where('name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%');
        });
    }

    public function members(){
        return $this->belongsToMany(Member::class, 'organization_members', 'organization_id', 'member_id')
            ->withPivot('role');
    }

}
