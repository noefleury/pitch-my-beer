<?php

namespace App\Models;

use App\Enums\FermenterType;
use App\Traits\Models\Commentable;
use Carbon\Carbon;
use Database\Factories\FermentationFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Fermentation
 *
 * @property int           $id
 * @property int           $wort_id
 * @property int           $fermenter_id
 * @property FermenterType $fermenter_type
 * @property float         $volume
 * @property Carbon        $created_at
 *
 * @property-read int      $fermenting_days
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

    public function beer()
    {
        return $this->hasOne(Beer::class);
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
