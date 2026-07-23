<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;

class TempLeadTest extends TestCase
{
    public function test_route_works()
    {
        $user = User::where('role', 'admin')->first();
        $this->withoutExceptionHandling();
        $response = $this->actingAs($user)->get('/admin/registration-leads');
        $response->assertStatus(200);
    }
}
