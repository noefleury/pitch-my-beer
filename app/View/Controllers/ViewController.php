<?php

namespace App\View\Controllers;

use App\Models\Beer;
use App\Services\BeerService;
use App\View\Components\Table;
use Illuminate\View\View;

class ViewController extends \Illuminate\Routing\ViewController
{

    public function showBeers(BeerService $beerService): View
    {
        $rows = Table::buildTableRows(
            $beerService->list(),
            [
                'uid',
                'name',
                'type',
                fn(Beer $beer) => $beer->created_at->toDateString(),
                fn(Beer $beer) => '<a href="'.route('beer', ['beer' => $beer->id]).'">'.__('See').'</a>',
            ],
        );

        return view('beers.list', [
            'headers' => ['#', 'Name', 'Type', 'Creation', 'See'],
            'rows'    => $rows,
            'trusted' => ['See'],
        ]);
    }

}
