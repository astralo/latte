<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Eve\Character;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    /** @test */
    public function dashboard_page_vailable()
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('dashboard.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_parse_characters()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $response = $this->post(route('dashboard.parse'), [
            'names' => 'DEMIST
            undefineduser11111;Gods Falanga'
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertEquals(2, Character::count());
        $this->assertEquals(1, Character::where('name', 'DEMIST')->count());
        $this->assertEquals(1, Character::where('name', 'Gods Falanga')->count());
    }
}
