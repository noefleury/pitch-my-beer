<?php

return [


    /**
     * Here we define custom identifier for some models
     */
    'unique_identifiers' => [
        \App\Models\Beer::class      => 'BER',
        \App\Models\Bottle::class    => 'BTL',
        \App\Models\Fermenter::class => 'FRM',
        \App\Models\GazTank::class   => 'GAZ',
        \App\Models\Keg::class       => 'KEG',
        \App\Models\Tap::class       => 'TAP',
    ],


];
