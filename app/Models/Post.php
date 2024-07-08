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
        'category_id',
        'description',
        'body',
        'color',
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
        return $this->hasMany(Category::class);
    }

    public function comments(){
        return $this->hasMany(PostComment::class);
    }

    public function reaction()
    {
        return $this->hasMany(Reaction::class);
    }

    public function userReactionsType()
    {
        $reactionType = $this->reaction()
            ->join('reaction_types', 'reactions.reaction_type_id', '=', 'reaction_types.id')
            ->where('reactions.user_id', auth()->id())
            ->value('reaction_types.icon'); // Utilise `value` au lieu de `pluck` pour obtenir une seule valeur

        return $reactionType ?: null; // Retourne le type de réaction ou `null` si aucun n'est trouvé
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
}

