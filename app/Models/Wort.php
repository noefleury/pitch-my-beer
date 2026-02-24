<?php

namespace App\Models;

use App\Traits\Commentable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Wort
 *
 * @property int    $id
 * @property string $notes
 * @property Carbon $created_at
 */
class Wort extends Model
{

    use Commentable;

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function fermentations(): HasMany
    {
        return $this->hasMany(Fermentation::class);
    }

}
