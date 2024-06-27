<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $books = Book::all();

        Reservation::factory(10)->make()->each(function($reservation) use ($users, $books) {
            $reservation->user()->associate($users->random());
            $book = $books->random();
            $reservation->book()->associate($book);
            $reservation->save();

            // Asegurarse de que cada libro solo tenga una reserva activa a la vez
            $books = $books->reject(function($b) use ($book) {
                return $b->id === $book->id;
            });
        });
    }
}
