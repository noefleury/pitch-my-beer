<?php

namespace App\Models;

use App\Enums\BeerStatus;
use App\Traits\Commentable;
use Carbon\Carbon;
use Database\Factories\BeerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Beer
 *
 * @property int        $id
 * @property string     $name
 * @property string     $type
 * @property ?float     $volume in liters
 * @property ?int       $fermentation_id
 * @property BeerStatus $status
 * @property Carbon     $created_at
 *
 * @see BeerFactory
 */
class Beer extends Model
{

    use Commentable;
    use HasFactory;

    public const null UPDATED_AT = null;

    protected $fillable = ['name', 'volume'];

    protected $casts = [
        'volume' => 'double',
        'status' => BeerStatus::class,
    ];

    public function fermentation(): BelongsTo
    {
        return $this->belongsTo(Fermentation::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
