<?php

namespace App\Models;

use App\Enums\FermenterType;
use App\Enums\KeggedType;
use App\Traits\Models\Commentable;
use Carbon\Carbon;
use Database\Factories\FermentationFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Fermentation
 *
 * @property int                                $id
 * @property int                                $wort_id
 * @property int                                $fermenter_id
 * @property FermenterType                      $fermenter_type
 * @property float                              $volume
 * @property Carbon                             $created_at
 *
 * @property-read HasOne|Wort                   $wort
 * @property-read MorphTo                       $fermenter
 * @property-read HasMany|FermentationGravity[] $gravities
 * @property-read HasOne|Beer                   $beer
 * @property-read HasMany|Kegging               $keggings
 * @property-read HasMany|Bottling              $bottlings
 *
 * @property-read int                           $fermenting_days
 * @see self::fermentingDays()
 *
 * @see FermentationFactory
 */
class Fermentation extends Model
{

    use Commentable;
    use HasFactory;

    public const null UPDATED_AT = null;

    protected $fillable = [
        'wort_id',
        'fermenter_id',
        'fermenter_type',
        'volume',
    ];

    protected $casts = [
        'fermenter_type' => FermenterType::class,
        'volume'         => 'double',
    ];

    public function wort(): BelongsTo
    {
        return $this->belongsTo(Wort::class);
    }

    /**
     *
     * @note can be a fermenter or a keg
     *
     * @return MorphTo
     * @see  FermenterType
     *
     */
    public function fermenter(): MorphTo
    {
        return $this->morphTo();
    }

    public function gravities()
    {
        return $this->hasMany(FermentationGravity::class);
    }

    public function beer(): HasOne
    {
        return $this->hasOne(Beer::class);
    }

    public function keggings(): HasMany
    {
        return $this->hasMany(Kegging::class, 'kegged_id')->where('kegged_type', KeggedType::Fermentation);
    }

    public function bottlings(): HasMany
    {
        return $this->hasMany(Bottling::class);
    }

    /**
     * Fermenting days duration
     *
     * @return Attribute
     */
    protected function fermentingDays(): Attribute
    {
        return Attribute::make(
            get: function () {
                return (int)$this->created_at->diffInDays();
            },
        );
    }

}
