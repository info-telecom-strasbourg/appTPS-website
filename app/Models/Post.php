<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bde\Organization;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Post extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'event_id',
        'organization_id',
        'media_id',
        'description',
        'body',
        'created_at',
        'uploaded_at',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function event(){
        return $this->hasMany(Event::class);
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    public function media(){
        return $this->hasMany(Media::class);
    }

    public function category(){
        return $this->HasMany(Category::class, 'post_id', 'id');
    }

    public function comments(){
        return $this->hasMany(PostComment::class);
    }

    public function reaction(){
        return $this->hasMany(Reaction::class);
    }

    public function userReactionsType()
    {
        $reaction = $this->reaction()
            ->join('reaction_types', 'reactions.reaction_type_id', '=', 'reaction_types.id')
            ->where('reactions.user_id', auth()->id())
            ->select('reaction_types.id', 'reaction_types.icon')
            ->first();

        return $reaction ? ['id' => $reaction->id, 'icon' => $reaction->icon] : null;
    }

    public function getDurationAttribute() {

        $date1 = new Carbon($this->uploaded_at); // Date d'upload du post

        $duration = $date1->diffForHumans();// Différence entre les dates

        return $duration; // Objet DateInterval

    }

    public function scopeFilter($query,$search)
    {
        $determinant_table = array("l'","un", "de", "d'", "le", "la", "les", "des", "du", "ce", "cet", "cette", "ces", "mon", "ma", "mes", "ton", "ta", "tes", "son", "sa", "ses", "notre", "nos", "votre", "vos", "leur", "leurs");
        $fullStringQuery = clone $query;
        $postsWithFullString = $fullStringQuery->where('body', 'LIKE', '%' . $search . '%')->get();


        // Vérifiez d'abord si la chaîne de recherche complète existe dans le corps du post

        if ($postsWithFullString->isNotEmpty()) {
            return $query->where('body', 'LIKE', '%' . $search . '%')->get();
        }
        else
        {
            // Si aucun post ne contient la chaîne de recherche complète, recherchez par mots individuels
            $searchWords = explode(' ', $search);

            // Supprime les déterminants de la recherche
            $searchWords = array_diff($searchWords, $determinant_table);

            if (!empty($searchWords)) {
                foreach ($searchWords as $word) {
                    $query->where(function ($query) use ($word) {
                        $query->where('body', 'LIKE', '%' . $word . '%');
                    });
                }
            }
            return $query->get();
        }
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

        // Return a default color if no categories are found
        return "#0865D2";
    }

    public function scopeCategory($query, $categoryIds)
    {
        return $query->whereHas('category', function ($query) use ($categoryIds) {
            $query->whereIn('category_type_id', $categoryIds);
        }, '>=', count($categoryIds));
    }

}

