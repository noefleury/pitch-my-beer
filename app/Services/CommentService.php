<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentService
{

    /**
     * List comments
     *
     * @note all comments without any entity scoping
     *
     * @return Collection<Comment>
     */
    public function list(): Collection
    {
        return Comment::query()->orderByDesc('id')->get()->setHidden([]);
    }

}
