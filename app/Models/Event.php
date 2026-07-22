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

    public function category(){
        return $this->hasMany(Category::class);
    }

    public function getEventTiming()
    {
        $start_at = Carbon::parse($this->start_at);
        $end_at = Carbon::parse($this->end_at);

        $timing = [
            'start_at_simplified' => $start_at->translatedFormat('H\hi'),
            'end_at_simplified' => $end_at->translatedFormat('H\hi'),
            'date' => $start_at->diffForHumans(),
            'days_diff' => $start_at->diffInDays($end_at)
        ];

        // if the event is today, tomorrow or in a week, then print the day of the week
        if ($start_at < now()->addWeek() ){
            if (now()->between($start_at, $end_at)){
                $timing['date'] = "En cours";
            }elseif($start_at < now()) {
                $timing['date'] = $start_at->diffForHumans();
            } elseif ($start_at->isToday()) {
                $timing['date'] = "Aujourd'hui";
            } else if ($start_at->isTomorrow()) {
                $timing['date'] = "Demain";
            } else {
                $timing['date'] = $start_at->translatedFormat('l');
            }
        }

        // if the event is more than 24 hours and less than 14 days, then print days and hours
        if (!$start_at->isSameDay($end_at)) {

            if ($start_at < now()->addWeeks(2)) {
                $timing['start_at_simplified'] = $start_at->translatedFormat('d/m H\hi');
                $timing['end_at_simplified'] = $end_at->translatedFormat('d/m H\hi');
            }
            else {
                $timing['start_at_simplified'] = $start_at->translatedFormat('d/m');
                $timing['end_at_simplified'] = $end_at->translatedFormat('d/m');
            }
        }

        return $timing;
    }

    public function getColor(){

        // Attempt to find a category that is for an event and get its color
        $eventCategoryColor = $this->category()
            ->join('category_types', 'categories.category_type_id', '=', 'category_types.id')
            ->where('category_types.is_for_event', true)
            ->orderBy('category_types.is_for_event', 'desc')
            ->first();

        // If an event category exists, return its color
        if ($eventCategoryColor) {
            return $eventCategoryColor->categoryType->color;
        }

        // If no event category, try to get the first category's color
        $anyCategoryColor = $this->category()
            ->join('category_types', 'categories.category_type_id', '=', 'category_types.id')
            ->first();

        if ($anyCategoryColor) {
            return $anyCategoryColor->categoryType->color;
        }

        // Return a default color or null if no categories are found
        return "#0865D2";
    }

    public function getShowDate($actual_date){
        $start_at = Carbon::parse($this->start_at);

        if (!$start_at->isSameDay($actual_date)) {
            return $start_at->translatedFormat('l d F');
        }
        else {
            return null;
        }
    }
}
