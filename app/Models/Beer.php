<?php

namespace App\Models;

use App\Enums\BeerStatus;
use App\Traits\Models\Commentable;
use App\Traits\Models\HasUniqueIdentifier;
use Carbon\Carbon;
use Database\Factories\BeerFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Beer
 *
 * @property int        $id
 * @property string     $name
 * @property string     $type
 * @property ?float     $volume      in liters
 * @property ?int       $fermentation_id
 * @property BeerStatus $status
 * @property Carbon     $created_at
 *
 * @property-read  bool $is_homemade
 * @see self::isHomemade()
 *
 * @see BeerFactory
 */
class Beer extends Model
{

    use Commentable;
    use HasFactory;
    use HasUniqueIdentifier;

    public const null UPDATED_AT = null;

    protected $fillable = ['name', 'volume'];

    protected $casts = [
        'volume' => 'double',
        'status' => BeerStatus::class,
    ];

    protected $appends = [
        'is_homemade',
    ];

    public function fermentation(): BelongsTo
    {
        return $this->belongsTo(Fermentation::class);
    }

    public function keggings(): HasMany
    {
        return $this->hasMany(Kegging::class)->withTrashed();
    }

    public function bottlings(): HasMany
    {
        return $this->hasMany(Bottling::class)->withTrashed();
    }

    protected function isHomemade(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => filled($this->fermentation_id),
        );
    }
}
