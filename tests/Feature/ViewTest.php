<?php

namespace Tests\Feature;

use App\Models\Fermenter;
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

    public function test_the_application_can_show_view_fermenter(): void
    {
        $this->get('/materials/fermenters/'.Fermenter::query()->first()->id)->assertOk();
    }


}
