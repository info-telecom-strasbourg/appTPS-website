<?php

namespace App\Models\Bde;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $connection = 'bde_bdd';

    protected $fillable = [
        'last_name',
        'first_name',
        'card_number',
        'email',
        'phone',
        'admin',
        'contributor',
        'class'
    ];

    public function getUpdatedAtColumn() {
        return null;
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function organizationMembers(){
        return $this->hasMany(OrganizationMember::class);
    }

}
