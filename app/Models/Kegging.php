<?php

namespace App\Models;

use App\Traits\Commentable;
use Carbon\Carbon;
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
 */
class Kegging extends Model
{

    use Commentable;

    protected $fillable = ['volume', 'keg_id', 'fermentation_id'];

    protected $casts = [
        'volume'     => 'float',
        'created_at' => 'datetime',
    ];

    public function keg(): BelongsTo
    {
        return $this->belongsTo(Keg::class);
    }

    public function fermentation(): BelongsTo
    {
        return $this->belongsTo(Fermentation::class);
    }

    public function link(): HasOne
    {
        return $this->hasOne(Link::class);
    }
}
