<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\book;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Book::with([
            'reservations',
            'category' => function ($query) {
                $query->select('id', 'name');
            },
        ])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());
        return response($book, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(book $book)
    {
        return $book->load(['reservations', 'category']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, book $book)
    {
        $book->update($request->validated());
        return response($book, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(book $book)
    {
        $book->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function search($title)
    {
        $books = Book::where('title', 'like', '%' . $title . '%')->get();
        return response()->json($books);
    }
}
