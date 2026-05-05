<?php

namespace App\Providers;

use App\Enums\FermenterType;
use App\Enums\KeggedType;
use App\Models\Authentication\User;
use App\Models\Beer;
use App\Models\Bottle;
use App\Models\Fermentation;
use App\Models\FermentationGravity;
use App\Models\Fermenter;
use App\Models\GazTank;
use App\Models\Keg;
use App\Models\Kegging;
use App\Models\Link;
use App\Models\Tap;
use App\Models\Wort;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // useful for Auth polymorphism
        Relation::enforceMorphMap([
            'user' => User::class,
        ]);

        // useful for Fermenter polymorphism
        Relation::enforceMorphMap([
            FermenterType::Fermenter->value => Fermenter::class,
            FermenterType::Keg->value       => Keg::class,
        ]);

        // useful for Kegging polymorphism
        Relation::enforceMorphMap([
            KeggedType::Beer->value    => Beer::class,
            KeggedType::Kegging->value => Kegging::class,
        ]);

        // useful for Commentable Trait polymorphism
        Relation::enforceMorphMap([
            'beer'                 => Beer::class,
            'bottle'               => Bottle::class,
            'fermentation'         => Fermentation::class,
            'fermentation_gravity' => FermentationGravity::class,
            'fermenter'            => Fermenter::class,
            'gaz_tank'             => GazTank::class,
            'keg'                  => Keg::class,
            'kegging'              => Kegging::class,
            'link'                 => Link::class,
            'tap'                  => Tap::class,
            'wort'                 => Wort::class,
        ]);
    }
}
