<?php

namespace App\Models;

use App\Traits\Models\Commentable;
use App\Traits\Models\HasUniqueIdentifier;
use Carbon\Carbon;
use Database\Factories\BottleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bottle
 *
 * @property int     $id
 * @property int     $volume (in milliliters)
 * @property Carbon  $created_at
 * @property ?Carbon $deleted_at
 *
 * @see BottleFactory
 */
class Bottle extends Model
{

    use Commentable;
    use HasFactory;
    use HasUniqueIdentifier;
    use SoftDeletes;

    public const null UPDATED_AT = null;

    protected $fillable = ['volume'];

    public function bottlings(): HasMany
    {
        return $this->hasMany(Bottling::class);
    }
}
