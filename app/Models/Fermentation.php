<?php

namespace App\Models;

use App\Enums\FermenterType;
use App\Traits\Commentable;
use Carbon\Carbon;
use Database\Factories\FermentationFactory;
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
 * @see FermentationFactory
 */
class Fermentation extends Model
{

    use Commentable;
    use HasFactory;

    public const null UPDATED_AT = null;

    protected $fillable = [
        'volume',
    ];

    protected $casts = [
        'fermenter_type' => FermenterType::class,
        'volume'         => 'float',
        'created_at'     => 'datetime',
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

}
