<?php

namespace App\Models;

use App\Traits\Models\Commentable;
use Carbon\Carbon;
use Database\Factories\BottlingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Bottling
 *
 * @property int    $id
 * @property int    $beer_id
 * @property int    $bottle_id
 * @property Carbon $created_at
 *
 * @see BottlingFactory
 */
class Bottling extends Model
{

    use Commentable;
    use HasFactory;

    public const null UPDATED_AT = null;

    public function beer(): BelongsTo
    {
        return $this->belongsTo(Beer::class);
    }

    public function bottle(): BelongsTo
    {
        return $this->belongsTo(Bottle::class);
    }

}
