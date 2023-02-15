<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    public function test_login_redirect_to_posts(): void
    {
        User::create([
            "name"=>"Aung Thu Zaw",
            "email"=>"aungthuzaw@gmail.com",
            "password"=>bcrypt("Password!")
        ]);


        $response=$this->post('/login', [
            "email"=>"aungthuzaw@gmail.com",
            "password"=>"Password!"
        ]);


        $response->assertStatus(302);
        $response->assertRedirect("posts");
    }
    public function test_unauthenticated_user_cannot_access_post(): void
    {
        $response = $this->get('/posts');

        $response->assertStatus(302);
        $response->assertRedirect("login");
    }
}
