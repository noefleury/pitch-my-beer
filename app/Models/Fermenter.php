<?php

namespace App\Models;

use App\Traits\Commentable;
use Carbon\Carbon;
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
 */
class Fermenter extends Model
{

    use Commentable;
    use SoftDeletes;

    protected $fillable = ['name', 'volume'];

    protected $casts = [
        'volume'     => 'float',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function fermentations(): MorphMany
    {
        return $this->morphMany(Fermentation::class, 'fermenter');
    }
}
