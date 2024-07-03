<?php

namespace App\Models;

use App\Models\Bde\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    protected $table = 'post_comments';

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_comment_id',
        'organization_id',
        'body',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
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
            ->value('reaction_types.name'); // Utilise `value` au lieu de `pluck` pour obtenir une seule valeur

        return $reactionType ?: null; // Retourne le type de réaction ou `null` si aucun n'est trouvé
    }


    public function getDurationAttribute() {

        $date1 = $this->created_at; // Date de création du post

        $duration = $date1->diffForHumans();// Différence entre les dates

        return $duration; // Objet DateInterval

    }

}
