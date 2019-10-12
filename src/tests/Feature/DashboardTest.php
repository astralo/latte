<?php declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    /** @test */
    public function dashboard_page_vailable()
    {
        $response = $this->get(route('dashboard.index'));

        $response->assertStatus(200);
    }
}
