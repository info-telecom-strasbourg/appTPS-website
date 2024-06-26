<?php

namespace App\Models\Bde;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrganizationMember extends Pivot
{
    use HasFactory;

    protected $connection = 'bde_bdd';

    public $timestamps = false;

    protected $fillable = [
        'member_id',
        'organization_id',
        'role',
    ];

    public function member(){
        return $this->belongsTo(Member::class);
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}
