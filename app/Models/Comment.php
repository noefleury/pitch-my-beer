<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Comment
 *
 * @property int    $id
 * @property int    $entity_id
 * @property string $entity_type
 * @property string $value
 * @property Carbon $created_at
 *
 * @see CommentFactory
 */
class Comment extends Model
{

    use HasFactory;

    public const null UPDATED_AT = null;

    protected $fillable = ['value'];

    protected $hidden = ['entity_id', 'entity_type'];

    public function entity(): MorphTo
    {
        return $this->morphTo();
    }

}
