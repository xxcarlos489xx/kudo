<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\User;

class RoutesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRouteLogin()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    
    }

    public function testRouteLogout()
    {
        $response = $this->get('/auth/logout');
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    public function testActionCorrectLogin()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->post('/auth/login');
        $this->assertTrue(Auth::check());
    }
}
