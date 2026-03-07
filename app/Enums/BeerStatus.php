<?php

namespace App\Enums;

enum BeerStatus: string
{

    case ToDo = 'todo';
    case Planned = 'planned';
    case Doing = 'doing';
    case Fermenting = 'fermenting';
    case Guarding = 'guarding';
    case Carbonating = 'carbonating';
    case Ready = 'ready';
    case Consumed = 'consumed';

    /**
     * Check if a beer have finished fermentation, from its given status
     *
     * @param   BeerStatus  $status
     *
     * @return bool
     */
    public static function finishedFermentation(self $status): bool
    {
        return !in_array($status, [
            self::ToDo,
            self::Planned,
            self::Doing,
            self::Fermenting,
        ]);
    }
}
