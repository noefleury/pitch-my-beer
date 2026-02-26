<?php

namespace App\Models;

use App\Traits\Models\Commentable;
use App\Traits\Models\HasUniqueIdentifier;
use Carbon\Carbon;
use Database\Factories\FermenterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Fermenter
 *
 * @property int     $id
 * @property ?string $name
 * @property float   $volume (in liters)
 * @property Carbon  $created_at
 * @property ?Carbon $deleted_at
 *
 * @see FermenterFactory
 */
class Fermenter extends Model
{

    use Commentable;
    use HasFactory;
    use HasUniqueIdentifier;
    use SoftDeletes;

    public const null UPDATED_AT = null;

    protected $fillable = ['name', 'volume'];

    protected $casts = [
        'volume' => 'double',
    ];

    public function fermentations(): MorphMany
    {
        return $this->morphMany(Fermentation::class, 'fermenter');
    }
}
