<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_title()
    {
        $book = Book::factory()->create(['title' => 'Sample Book']);
        $this->assertEquals('Sample Book', $book->title);
    }


    /** @test */
    public function it_can_create_a_book()
    {
        // Create a user
        $user = User::factory()->create();

        // Authenticate the user
        Sanctum::actingAs($user);

        $data = [
            'title' => 'Sample Book',
            'author' => 'John Doe',
            'description' => 'Excelente book',
        ];

        $response = $this->postJson('/api/books', $data);

        $response->assertStatus(201)
            ->assertJson($data);
        $this->assertDatabaseHas('books', $data);
    }

    /** @test */
    public function it_can_update_a_book()
    {
        // Create a user
        $user = User::factory()->create();

        // Authenticate the user
        Sanctum::actingAs($user);

        $book = Book::factory()->create();
        $data = ['title' => 'Updated Title'];

        $response = $this->putJson("/api/books/{$book->id}", $data);

        $response->assertStatus(200)
            ->assertJson($data);
        $this->assertDatabaseHas('books', $data);
    }

    /**
     * @test
     */
    public function it_can_delete_a_book()
    {
        // Create a user
        $user = User::factory()->create();

        // Authenticate the user
        Sanctum::actingAs($user);

        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
    }
