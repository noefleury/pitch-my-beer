<?php

namespace App\Models;

use App\Traits\Models\Commentable;
use Carbon\Carbon;
use Database\Factories\WortFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Wort
 *
 * @property int    $id
 * @property Carbon $created_at
 *
 * @see WortFactory
 */
class Wort extends Model
{

    use Commentable;
    use HasFactory;

    public const null UPDATED_AT = null;

    public function fermentations(): HasMany
    {
        return $this->hasMany(Fermentation::class);
    }

}
