<?php

namespace App\Traits;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @note don't forget to add Model in AppServiceProvider -> Relation::enforceMorphMap()
 */
trait Commentable
{

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'entity');
    }

}
