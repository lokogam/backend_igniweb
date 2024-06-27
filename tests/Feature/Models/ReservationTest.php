<?php

namespace Tests\Feature\Models;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_reservation_can_be_created()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
    }
}
