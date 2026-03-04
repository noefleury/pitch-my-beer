<?php

namespace Tests\Feature;

use App\Models\Bottle;
use App\Models\Fermenter;
use App\Models\GazTank;
use App\Models\Keg;
use App\Models\Tap;
use Tests\TestCase;

class ViewTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_the_application_can_show_view_materials(): void
    {
        $this->get('/materials')->assertOk();
    }

    public function test_the_application_can_show_view_materials_find_by_uid(): void
    {
        $gazTankId = GazTank::query()->first()->id;
        $uid       = urlencode("GAZ#$gazTankId");

        $this->get("/materials/find/$uid")->assertRedirect("/materials/gaz-tanks/$gazTankId");
    }

    public function test_the_application_can_show_view_fermenter(): void
    {
        $this->get('/materials/fermenters/'.Fermenter::query()->first()->id)->assertOk();
    }

    public function test_the_application_can_show_view_gaz_tank(): void
    {
        $this->get('/materials/gaz-tanks/'.GazTank::query()->first()->id)->assertOk();
    }

    public function test_the_application_can_show_view_keg(): void
    {
        $this->get('/materials/kegs/'.Keg::query()->first()->id)->assertOk();
    }

    public function test_the_application_can_show_view_tap(): void
    {
        $this->get('/materials/taps/'.Tap::query()->first()->id)->assertOk();
    }

    public function test_the_application_can_show_view_bottle(): void
    {
        $this->get('/materials/bottles/'.Bottle::query()->first()->id)->assertOk();
    }


}
