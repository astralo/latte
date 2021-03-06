<?php

namespace Tests\Unit\Services;

use App\Services\FindCharacterByName;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FindCharacterByNameTest extends TestCase
{
    /**
     * @var FindCharacterByName
     */
    protected $service;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->service = new FindCharacterByName();
    }

    /** @test */
    public function itCanFindCharacterAndReturnId()
    {
        $result = $this->service->find('DEMIST');

        $this->assertEquals(1749885637, $result);
    }

    /** @test */
    public function searchOfNonexistentCharacterReturnsNull()
    {
        $result = $this->service->find('unexistenuserundatabase');

        $this->assertEquals(null, $result);
    }
}
