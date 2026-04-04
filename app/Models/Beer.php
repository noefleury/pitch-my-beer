<?php

namespace App\Models;

use App\Enums\BeerStatus;
use App\Helpers\Abv;
use App\Traits\Models\Commentable;
use App\Traits\Models\HasUniqueIdentifier;
use Carbon\Carbon;
use Database\Factories\BeerFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Tests\Feature\Models\BeerTest;

/**
 * Class Beer
 *
 * @property int        $id
 * @property string     $name
 * @property string     $type
 * @property ?float     $volume      in liters
 * @property ?int       $fermentation_id
 * @property ?float     $abv         in %
 * @property BeerStatus $status
 * @property Carbon     $created_at
 *
 * @property-read  bool $is_homemade
 * @see self::isHomemade()
 *
 * @see self::abv()
 *
 * @see self::consumed() scope
 *
 * @see self::homemade() scope
 * @see self::bought() scope
 *
 * @see BeerFactory
 * @see BeerTest
 */
class Beer extends Model
{

    use Commentable;
    use HasFactory;
    use HasUniqueIdentifier;

    public const null UPDATED_AT = null;

    protected $fillable = ['name', 'type', 'volume', 'fermentation_id', 'abv', 'status'];

    protected $casts = [
        'volume' => 'double',
        'abv'    => 'double',
        'status' => BeerStatus::class,
    ];

    protected $appends = [
        'is_homemade',
    ];

    protected $hidden = [
        'fermentation', // as appended by abv() accessor
    ];

    public function fermentation(): BelongsTo
    {
        return $this->belongsTo(Fermentation::class);
    }

    public function keggings(): MorphMany
    {
        return $this->morphMany(Kegging::class, 'kegged')->withTrashed();
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

    /**
     * Auto-computed from gravities when null and beer finished fermenting
     *
     * @return Attribute
     */
    protected function abv(): Attribute
    {
        return Attribute::make(
            get: function (?float $abv) {
                if (filled($abv)) {
                    return $abv;
                }
                if (BeerStatus::finishedFermentation($this->status)) {
                    $gravities = $this->fermentation->gravities()->oldest('id')->get();
                    if ($gravities->count() >= 2) {
                        return Abv::computeFromGravities($gravities->first()->value, $gravities->last()->value);
                    }
                }

                return null;
            },
        );
    }

    #[Scope]
    protected function consumed(Builder $query)
    {
        return $query->where('status', BeerStatus::Consumed);
    }

    #[Scope]
    protected function homemade(Builder $query)
    {
        return $query->whereNotNull('fermentation_id');
    }

    #[Scope]
    protected function bought(Builder $query)
    {
        return $query->whereNull('fermentation_id');
    }

}
