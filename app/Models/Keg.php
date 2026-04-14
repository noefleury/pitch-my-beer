<?php

namespace App\Models;

use App\Traits\Models\Commentable;
use App\Traits\Models\HasUniqueIdentifier;
use Carbon\Carbon;
use Database\Factories\KegFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class Keg
 *
 * @property int     $id
 * @property ?string $name
 * @property float   $volume (in liters)
 * @property Carbon  $created_at
 * @property ?Carbon $deleted_at
 *
 * @see KegFactory
 */
class Keg extends Model
{

    use Commentable;
    use HasFactory;
    use HasUniqueIdentifier;

    public const null UPDATED_AT = null;

    protected $fillable = ['name', 'volume'];

    protected $casts = [
        'volume' => 'double',
    ];

    public function fermentations(): MorphMany
    {
        return $this->morphMany(Fermentation::class, 'fermenter');
    }

    public function keggings(): HasMany
    {
        return $this->hasMany(Kegging::class);
    }
}
