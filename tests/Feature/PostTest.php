<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user=$this->createUser();
    }

    public function test_post_page_contains_empty_table(): void
    {
        $response = $this->actingAs($this->user)->get('/posts');

        $response->assertStatus(200);
        $response->assertSee(__("Post Not Found!"));
    }

    public function test_post_page_does_not_contain_empty_table(): void
    {
        Post::create([
            "thumbnail"=>"photo.jpg",
            "title"=>"Aung Thu Zaw",
            "body"=>"aungthuzaw@gmail.com",
            "view"=>4,
        ]);

        $response = $this->actingAs($this->user)->get('/posts');

        $response->assertStatus(200);
        $response->assertDontSee(__("Post Not Found!"));
    }

    public function test_paginated_posts_table_does_not_contain_16th_record(): void
    {
        $postCollection=Post::factory(20)->create();
        $sixteenRecord=$postCollection->find(16);

        $response = $this->actingAs($this->user)->get('/posts');

        $response->assertStatus(200);
        $response->assertViewHas("posts", function ($collection) use ($sixteenRecord) {
            return !$collection->contains($sixteenRecord);
        });
    }


    private function createUser()
    {
        return User::factory()->create();
    }
}
