<?php

namespace App\Enums;

enum KeggedType: string
{

    case Beer = 'beer'; // eg: when bough beer
    case Fermentation = 'fermentation'; // eg: normal kegging
    case Kegging = 'kegging'; // eg: when doing transfer

}
