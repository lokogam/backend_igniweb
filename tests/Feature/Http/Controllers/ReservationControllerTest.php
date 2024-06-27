<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\WithFaker;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_get_all_reservations()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Reservation::factory()->count(5)->create();
        $response = $this->getJson(route('reservations.index'));

        $response->assertStatus(200);
        $this->assertCount(5, $response->json());
    }

    public function test_can_create_reservation()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        // Authenticate the user
        Sanctum::actingAs($user);

        $data = [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'reservation_days' => 7,
            'status' => 'Active',
        ];

        $response = $this->postJson(route('reservations.store'), $data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('reservations', $data);
    }

    public function test_can_show_reservation()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $reservation = Reservation::factory()->create();
        $response = $this->getJson(route('reservations.show', $reservation));

        $response->assertStatus(200)
            ->assertJson($reservation->toArray());
    }

    public function test_can_update_reservation()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $reservation = Reservation::factory()->create();
        $data = ['reservation_days' => 10];

        $response = $this->putJson(route('reservations.update', $reservation), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('reservations', array_merge($reservation->toArray(), $data));
    }

    public function test_can_delete_reservation()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $reservation = Reservation::factory()->create();
        $response = $this->deleteJson(route('reservations.destroy', $reservation));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('reservations', $reservation->toArray());
    }
}
