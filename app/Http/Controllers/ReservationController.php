<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Http\Response;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $filteredReservations = Reservation::where('status', 'Active')
            ->where('user_id', auth()->user()->id)
            ->pluck('book_id');

        $books = Book::with([
            'reservations',
            'category' => function ($query) {
                $query->select('id', 'name');
            },
        ])
            ->whereIn('id', $filteredReservations)
            ->get();

        return $books;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {

        $book = Book::findOrFail($request->input('book_id'));

        if (!$book->is_available_for_reservation()) {
            return response()->json(['error' => 'El libro no está disponible actualmente para reserva.'], 400);
        }

        $reservation = Reservation::create($request->validated());
        return response($reservation, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        return $reservation;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $reservation->update($request->validated());
        return response($reservation, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
