<?php

namespace Tests\Unit\Jobs\Eve\Loaders;

use App\Models\Eve\Character;
use Swagger\Client\Api\CharacterApi;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CharacterBasicTest extends TestCase
{
    /** @test */
    public function itCanParseCharacterAndSaveToDatabase()
    {
        $job = new \App\Jobs\Eve\Loaders\CharacterBasic(1749885637);

        $this->assertEquals(0, Character::count());

        $job->handle();

        $this->assertEquals(1, Character::count());
        $this->assertInstanceOf(Character::class, Character::find(1749885637));
        $this->assertEquals('DEMIST', Character::find(1749885637)->name);
    }
}
