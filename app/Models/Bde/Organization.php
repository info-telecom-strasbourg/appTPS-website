<?php

namespace App\Models\Bde;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $connection = 'bde_bdd';

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
        return env('FOUAILLE_URL') . 'storage/organizations/' . $this->logo;
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }
}
