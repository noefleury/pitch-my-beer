<?php

namespace App\Models;

use App\Traits\Models\Commentable;
use Carbon\Carbon;
use Database\Factories\KeggingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Kegging
 *
 * @property int     $id
 * @property float   $volume (in liters)
 * @property int     $beer_id
 * @property int     $keg_id
 * @property Carbon  $created_at
 * @property ?Carbon $deleted_at
 *
 * @see KeggingFactory
 */
class Kegging extends Model
{

    use Commentable;
    use HasFactory;
    use SoftDeletes;

    public const null UPDATED_AT = null;

    protected $fillable = ['volume', 'beer_id', 'keg_id'];

    protected $casts = [
        'volume' => 'double',
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
