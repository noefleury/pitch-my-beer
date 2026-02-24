<?php

namespace App\Models;

use App\Traits\Commentable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Link
 *
 * @property int     $id
 * @property int     $kegging_id
 * @property int     $gaz_tank_id
 * @property int     $tap_id
 * @property Carbon  $created_at
 * @property ?Carbon $deleted_at
 */
class Link extends Model
{

    use Commentable;
    use SoftDeletes;

    public function beer(): BelongsTo
    {
        return $this->belongsTo(Beer::class);
    }

    public function gazTank(): BelongsTo
    {
        return $this->belongsTo(GazTank::class);
    }

    public function tap(): BelongsTo
    {
        return $this->belongsTo(Tap::class);
    }
}
