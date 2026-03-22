<?php

namespace App\Models;

use App\Enums\KeggedType;
use App\Traits\Models\Commentable;
use Carbon\Carbon;
use Database\Factories\KeggingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Kegging
 *
 * @property int        $id
 * @property float      $volume (in liters)
 * @property int        $kegged_id
 * @property KeggedType $kegged_type
 * @property int        $keg_id
 * @property Carbon     $created_at
 * @property ?Carbon    $deleted_at
 *
 * @see KeggingFactory
 */
class Kegging extends Model
{

    use Commentable;
    use HasFactory;
    use SoftDeletes;

    public const null UPDATED_AT = null;

    protected $fillable = ['volume', 'kegged_id', 'kegged_type', 'keg_id'];

    protected $casts = [
        'volume'      => 'double',
        'kegged_type' => KeggedType::class,
    ];

    /**
     * @note can be a Beer or a Kegging
     *
     * @return BelongsTo
     * @see  KeggedType
     */
    public function kegged(): BelongsTo
    {
        return $this->morphTo();
    }

    public function keggings(): MorphMany
    {
        return $this->morphMany(Kegging::class, 'kegged')->withTrashed();
    }

    public function keg(): BelongsTo
    {
        return $this->belongsTo(Keg::class);
    }

    public function link(): HasOne
    {
        return $this->hasOne(Link::class);
    }

    /**
     * This method will return kegged Beer
     *
     * @note for transfer > it will recursively find the beer through parents
     *
     * @return Beer
     */
    public function beer(): Beer
    {
        if ($this->kegged_type === KeggedType::Beer) {
            return $this->kegged;
        } else {
            return $this->kegged->beer();
        }
    }

    /**
     * This method will return transfers from this Kegging
     *
     * @param   bool  $recursive  to recursively check through multiple transfers (eg: K1 -> K2 -> K3)
     *
     * @return array<Kegging>
     */
    public function transfers(bool $recursive = false): array
    {
        $transfers = [];

        $this->keggings()
            ->with('keg:id')
            ->each(function (Kegging $kegging) use (&$transfers, $recursive) {
                $kegging->load('kegged.keg');
                $transfers[] = $kegging;
                if ($recursive) {
                    array_push($transfers, ...$kegging->transfers());
                }
            });

        return $transfers;
    }

}
