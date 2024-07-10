<?php

namespace App\Models;

use App\Models\Bde\Organization;
use App\Models\Bde\OrganizationMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'organization_id',
        'start_at',
        'end_at',
        'uploaded_at',
        'title',
        'body',
        'location',
        'color',
        'created_at',
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

    public function getEventTiming()
    {
        $startAt = Carbon::parse($this->start_at);
        $endAt = Carbon::parse($this->end_at);
        $differenceInHours = $endAt->diffInHours($startAt);
        $differenceInDays = now()->diffInDays($startAt);

        $timing = [
            'start_at_simplified' => $startAt->translatedFormat('H\hi'),
            'end_at_simplified' => $endAt->translatedFormat('H\hi'),
            'date' => $startAt->translatedFormat('d F'),
            'days_diff' => $startAt->diffInDays($endAt)
        ];

        if ($differenceInDays < 7) {
            $timing['date'] = $startAt->translatedFormat('l');
        }

        // if the event is more than 24 hours and less than 14 days, then print days and hours
        if ($differenceInHours > 24) {

            if ($differenceInDays < 7) {
                $timing['date'] = $startAt->translatedFormat('l') . ' - ' . $endAt->translatedFormat('l');
            }else {
                $timing['date'] = $startAt->translatedFormat('d F') . ' - ' . $endAt->translatedFormat('d F');
            }
            if ($differenceInDays < 7){
                $timing['start_at_simplified'] = $startAt->translatedFormat('d F H\hi');
                $timing['end_at_simplified'] = $endAt->translatedFormat('d F H\hi');
            }
            else {
                $timing['start_at_simplified'] = $startAt->translatedFormat('d F');
                $timing['end_at_simplified'] = $endAt->translatedFormat('d F');
            }
        }

        return $timing;
    }
}
