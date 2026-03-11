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
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class GazTank
 *
 * @property int          $id
 * @property ?string      $name
 * @property float        $volume
 * @property float        $co2_percent
 * @property float        $n2_percent
 * @property Carbon       $created_at
 * @property ?Carbon      $deleted_at
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
    use SoftDeletes;

    public const null UPDATED_AT = null;

    protected $casts = [
        'volume' => 'double',
    ];

    protected $fillable = ['name', 'volume', 'co2_percent', 'n2_percent'];

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
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
