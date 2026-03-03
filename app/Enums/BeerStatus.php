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

}
