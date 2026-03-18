<?php

namespace App\Models;

use App\Traits\Models\Commentable;
use Carbon\Carbon;
use Database\Factories\BottlingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bottling
 *
 * @property int     $id
 * @property int     $beer_id
 * @property int     $bottle_id
 * @property Carbon  $created_at
 * @property ?Carbon $deleted_at
 *
 * @see BottlingFactory
 */
class Bottling extends Model
{

    use Commentable;
    use HasFactory;
    use SoftDeletes;

    public const null UPDATED_AT = null;

    protected $fillable = ['beer_id', 'bottle_id'];

    public function beer(): BelongsTo
    {
        return $this->belongsTo(Beer::class);
    }

    public function bottle(): BelongsTo
    {
        return $this->belongsTo(Bottle::class);
    }

}
