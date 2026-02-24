<?php

namespace App\Models;

use App\Traits\Commentable;
use Carbon\Carbon;
use Database\Factories\KeggingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Kegging
 *
 * @property int    $id
 * @property float  $volume (in liters)
 * @property int    $beer_id
 * @property int    $keg_id
 * @property Carbon $created_at
 *
 * @see KeggingFactory
 */
class Kegging extends Model
{

    use Commentable;
    use HasFactory;

    public const null UPDATED_AT = null;

    protected $fillable = ['volume'];

    protected $casts = [
        'volume'     => 'float',
        'created_at' => 'datetime',
    ];

    public function beer(): BelongsTo
    {
        return $this->belongsTo(Beer::class);
    }

    public function keg(): BelongsTo
    {
        return $this->belongsTo(Keg::class);
    }

    public function link(): HasOne
    {
        return $this->hasOne(Link::class);
    }
}
