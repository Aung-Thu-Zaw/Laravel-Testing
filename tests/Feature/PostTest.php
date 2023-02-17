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
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user=$this->createUser();
        $this->admin=$this->createUser(isAdmin:true);
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


    public function test_non_admin_cannot_see_post_create_button()
    {
        $response = $this->actingAs($this->user)->get('/posts');

        $response->assertStatus(200);
        $response->assertDontSee("Create");
    }


    public function test_admin_can_see_post_create_button()
    {
        $response = $this->actingAs($this->admin)->get('/posts');

        $response->assertStatus(200);
        $response->assertSee("Create");
    }


    public function test__admin_can_access_post_create_form_page()
    {
        $response = $this->actingAs($this->admin)->get('/posts/create');

        $response->assertStatus(200);
    }


    public function test__non_admin_cannot_access_post_create_form_page()
    {
        $response = $this->actingAs($this->user)->get('/posts/create');

        $response->assertStatus(403);
    }

    public function test_create_post_successful()
    {
        $post=[
            "title"=>"This is a title",
            "body"=>"This is a body"
        ];

        $response=$this->actingAs($this->admin)->post("/posts", $post);

        $response->assertStatus(302);
        $response->assertRedirect("posts");

        $this->assertDatabaseHas("posts", $post);

        $lastPost=Post::latest()->first();
        $this->assertEquals($post["title"], $lastPost->title);
        $this->assertEquals($post["body"], $lastPost->body);
    }

    public function test_admin_can_see_post_edit_button()
    {
        Post::factory()->create();

        $response = $this->actingAs($this->admin)->get("/posts");

        $response->assertStatus(200);
        $response->assertSee("Edit");
    }

    public function test_post_edit_contains_correct_value()
    {
        $post=Post::factory()->create();

        $response = $this->actingAs($this->admin)->get("/posts/$post->id/edit");

        $response->assertStatus(200);
        $response->assertSee('value="'.$post->title.'"', false);
        $response->assertSee('value="'.$post->body.'"', false);
        $response->assertViewHas("post", $post);
    }

    private function createUser($isAdmin=false)
    {
        return User::factory()->create([
            "is_admin"=>$isAdmin
        ]);
    }
}
