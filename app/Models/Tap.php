<?php

namespace App\Models;

use App\Enums\TapType;
use App\Traits\Commentable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Tap
 *
 * @property int     $id
 * @property int     $name
 * @property TapType $type
 * @property Carbon  $created_at
 * @property ?Carbon $deleted_at
 */
class Tap extends Model
{

    use Commentable;
    use SoftDeletes;

    protected $fillable = ['name', 'type'];

    protected $casts = [
        'type'       => TapType::class,
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
