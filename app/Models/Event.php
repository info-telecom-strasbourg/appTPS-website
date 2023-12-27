<?php

namespace App\Models;

use App\Models\Bde\Organization;
use App\Models\Bde\OrganizationMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization_id',
        'start_at',
        'end_at',
        'title',
        'body',
        'location',
    ];

    protected $with = ['user'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    public function post(){
        return $this->hasMany(Post::class);
    }
}
