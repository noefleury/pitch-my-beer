<?php

namespace App\Models;

use App\Traits\Models\Commentable;
use App\Traits\Models\HasUniqueIdentifier;
use Carbon\Carbon;
use Database\Factories\GazTankFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class GazTank
 *
 * @property int          $id
 * @property ?string      $name
 * @property float        $volume
 * @property int          $co2_percent
 * @property Carbon       $created_at
 * @property ?Carbon      $deleted_at
 *
 * @property-read  int    $n2_percent
 * @see self::n2Percent()
 *
 * @property-read  string $blend
 * @see self::blend()
 *
 * @see GazTankFactory
 */
class GazTank extends Model
{

    use Commentable;
    use HasFactory;
    use HasUniqueIdentifier;

    public const null UPDATED_AT = null;

    protected $casts = [
        'volume' => 'double',
    ];

    protected $fillable = ['name', 'volume', 'co2_percent'];

    protected $appends = [
        'n2_percent',
    ];

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    /**
     * Get n2 percentage inside bottle
     * @return Attribute
     */
    protected function n2Percent(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => 100 - $attributes['co2_percent'],
        );
    }

    /**
     * Format blend gaz to string
     * @return Attribute
     */
    protected function blend(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $this->co2_percent.'/'.$this->n2_percent,
        );
    }
}
