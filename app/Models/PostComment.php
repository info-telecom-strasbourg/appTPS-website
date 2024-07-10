<?php

namespace App\Models;

use App\Models\Bde\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostComment extends Model
{
    use HasFactory;

    use SoftDeletes;

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
        $reaction = $this->reaction()
            ->join('reaction_types', 'reactions.reaction_type_id', '=', 'reaction_types.id')
            ->where('reactions.user_id', auth()->id())
            ->select('reaction_types.id', 'reaction_types.icon')
            ->first();

        return $reaction ? ['id' => $reaction->id, 'icon' => $reaction->icon] : null;
    }



    public function getDurationAttribute() {

        $date1 = $this->created_at; // Date de création du post

        $duration = $date1->diffForHumans();// Différence entre les dates

        return $duration; // Objet DateInterval

    }

    public function childrenscount(){
        return PostComment::where('parent_comment_id',$this->id)->count();
    }

}
