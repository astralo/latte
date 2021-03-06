<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CharactersNamesTest extends TestCase
{
    /**
     * @var \App\Services\CharactersNames
     */
    protected $service;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->service = new \App\Services\CharactersNames();
    }

    /** @test */
    public function parseCharactersNamesReturnsArrayOfNames()
    {
        $input = 'Charname1
        Charname2;Charname3     ;     Charname4
        Charname5;';

        $result = $this->service->parse($input);

        $this->assertSame([
            'Charname1',
            'Charname2',
            'Charname3',
            'Charname4',
            'Charname5'
        ], $result);
    }
}
