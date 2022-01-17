<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Address;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testRoute()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testLoginRoute()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testRegisterRoute()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function testUserLoginRoute()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/home');
    }
}
