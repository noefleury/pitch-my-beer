<?php

namespace App\Models;

use App\Traits\Commentable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class GazTank
 *
 * @property int     $id
 * @property ?string $name
 * @property float   $co2_percent
 * @property float   $n2_percent
 * @property Carbon  $created_at
 * @property ?Carbon $deleted_at
 */
class GazTank extends Model
{

    use Commentable;
    use SoftDeletes;

    protected $fillable = ['name', 'co2_percent', 'n2_percent'];

    protected $casts = [
        'co2_percent' => 'float',
        'n2_percent'  => 'float',
    ];

    public function links(): HasMany

    {
        return $this->hasMany(Link::class);
    }
}
