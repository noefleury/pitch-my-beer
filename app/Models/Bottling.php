<?php

namespace App\Models;

use App\Traits\Models\Commentable;
use Carbon\Carbon;
use Database\Factories\BottlingFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bottling
 *
 * @property int         $id
 * @property int         $beer_id
 * @property int         $bottle_id
 * @property Carbon      $created_at
 * @property ?Carbon     $deleted_at
 *
 * @property-read Beer   $beer
 * @property-read Bottle $bottle
 *
 * @property-read int    $guarding_days
 * @see self::guardingDays()
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

    protected $appends = ['guarding_days'];

    public function beer(): BelongsTo
    {
        return $this->belongsTo(Beer::class);
    }

    public function bottle(): BelongsTo
    {
        return $this->belongsTo(Bottle::class);
    }

    /**
     * Guarding days duration from bottling date
     *
     * @return Attribute
     */
    protected function guardingDays(): Attribute
    {
        return Attribute::make(
            get: function () {
                return (int)$this->created_at->diffInDays();
            },
        );
    }
}
