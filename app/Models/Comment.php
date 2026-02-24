<?php

namespace App\Models;

use Carbon\Carbon;
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
 */
class Comment extends Model
{
    protected $fillable = ['value'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function entity(): MorphTo
    {
        return $this->morphTo();
    }

}
