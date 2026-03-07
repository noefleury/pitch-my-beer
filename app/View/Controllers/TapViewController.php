<?php

namespace App\View\Controllers;

use App\Services\TapService;
use App\View\Components\Table;
use Illuminate\Routing\ViewController;
use Illuminate\View\View;

class TapViewController extends ViewController
{

    public function showOnTaps(TapService $tapService): View
    {
        $onTaps = $tapService->getOnTaps();

        $headers = ['Type', 'Name', 'Gaz', 'Tap', 'Date'];

        $rows = Table::buildTableRows($onTaps, [
            'beer_type',
            'beer_name',
            'gaz_blend',
            'tap_type',
            fn(object $link) => $link->date->toDateString(),
        ]);

        return view('on-taps', [
            'headers' => $headers,
            'rows'    => $rows,
        ]);
    }

}
