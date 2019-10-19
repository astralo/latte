<?php

namespace Tests\Unit\Jobs\Eve\Loaders;

use App\Models\Eve\Alliance;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllianceBasicTest extends TestCase
{
    /** @test */
    public function itCanParseCharacterAndSaveToDatabase()
    {
        $job = new \App\Jobs\Eve\Loaders\AllianceBasic(434243723);

        $this->assertEquals(0, Alliance::count());

        $job->handle();

        $this->assertEquals(1, Alliance::count());
        $this->assertInstanceOf(Alliance::class, Alliance::find(434243723));
        $this->assertEquals('C C P Alliance', Alliance::find(434243723)->name);
    }
}
