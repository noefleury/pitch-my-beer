<?php

namespace App\Enums;

enum KeggedType: string
{

    case Beer = 'beer'; // eg: normal kegging (could have been fermentation too..)
    case Kegging = 'kegging'; // eg: when doing transfer

}
