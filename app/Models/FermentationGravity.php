<?php

namespace App\Models;

use App\Traits\Commentable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class FermentationGravity
 *
 * @property int    $id
 * @property int    $fermentation_id
 * @property float  $value
 * @property Carbon $created_at
 */
class FermentationGravity extends Model
{

    use Commentable;

    protected $fillable = ['value'];

    protected $casts = [
        'value'      => 'float',
        'created_at' => 'datetime',
    ];

    public function fermentation(): BelongsTo
    {
        return $this->belongsTo(Fermentation::class);
    }
}
