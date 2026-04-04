<?php

namespace App\View\Controllers;

use App\Helpers\Volume;
use App\Models\Bottling;
use App\Services\BottlingService;
use App\View\Components\Table;
use Illuminate\Routing\ViewController;
use Illuminate\View\View;

class BottlingViewController extends ViewController
{

    public function showBottlings(BottlingService $bottlingService): View
    {
        $bottlings = $bottlingService->list();

        $headers = ['Beer', 'Type', 'Volume', 'Days'];

        $rows = Table::buildTableRows($bottlings, [
            fn(Bottling $bottling) => $bottling->beer->name,
            fn(Bottling $bottling) => $bottling->beer->type,
            fn(Bottling $bottling) => Volume::getFormattedValue($bottling->bottle->volume / 1000),
            'guarding_days',
        ]);

        return view('bottlings', [
            'headers' => $headers,
            'rows'    => $rows,
        ]);
    }

}
