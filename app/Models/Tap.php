<?php

namespace App\Models;

use App\Enums\TapType;
use App\Traits\Models\Commentable;
use App\Traits\Models\HasUniqueIdentifier;
use Carbon\Carbon;
use Database\Factories\TapFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tap
 *
 * @property int     $id
 * @property int     $name
 * @property TapType $type
 * @property Carbon  $created_at
 * @property ?Carbon $deleted_at
 *
 * @see TapFactory
 */
class Tap extends Model
{

    use Commentable;
    use HasFactory;
    use HasUniqueIdentifier;

    public const null UPDATED_AT = null;

    protected $fillable = ['name', 'type'];

    protected $casts = [
        'type' => TapType::class,
    ];

    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
