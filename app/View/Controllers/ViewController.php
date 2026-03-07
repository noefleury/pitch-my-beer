<?php

namespace App\View\Controllers;

use App\Models\Beer;
use App\Models\Bottling;
use App\Models\Kegging;
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

    public function showBeer(BeerService $beerService, Beer $beer): View
    {
        $beer          = $beerService->get($beer);
        $beerRelations = $beerService->getRelationsData($beer);

        $keggingsRows = Table::buildTableRows(
            $beerRelations['keggings'],
            [
                fn(Kegging $kegging) => $kegging->volume.' L',
                fn(Kegging $kegging) => $kegging->deleted_at ? __('No') : __('Yes'),
                fn(Kegging $kegging) => $kegging->keg->uid,
            ],
        );

        $bottlingsRows = Table::buildTableRows(
            $beerRelations['bottlings'],
            [
                fn(Bottling $bottling) => $bottling->bottle->volume.' mL',
                fn(Bottling $bottling) => $bottling->deleted_at ? __('No') : __('Yes'),
                fn(Bottling $bottling) => $bottling->bottle->uid,
            ],
        );

        return view('beers.beer', [
            'beer'             => $beer,
            'relations'        => (object)$beerService->getRelationsData($beer),
            'keggingsHeaders'  => ['Volume', 'Available', 'Keg'],
            'keggingsRows'     => $keggingsRows,
            'bottlingsHeaders' => ['Volume', 'Available', 'Bottle'],
            'bottlingsRows'    => $bottlingsRows,
        ]);
    }

}
