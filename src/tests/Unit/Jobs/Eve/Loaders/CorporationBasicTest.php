<?php

namespace Tests\Unit\Jobs\Eve\Loaders;

use App\Models\Eve\Corporation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CorporationBasicTest extends TestCase
{
    /** @test */
    public function itCanParseCorporationAndSaveToDatabase()
    {
        $job = new \App\Jobs\Eve\Loaders\CorporationBasic(98515207);

        $this->assertEquals(0, Corporation::count());

        $job->handle();

        $this->assertEquals(1, Corporation::count());
        $this->assertInstanceOf(Corporation::class, Corporation::find(98515207));
        $this->assertEquals('XAOS RELOADED', Corporation::find(98515207)->name);
    }
}
