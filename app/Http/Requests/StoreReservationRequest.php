<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // return [
        //     'user_id' => 'required|exists:users,id',
        //     'book_id' => 'required|exists:books,id',
        //     'reservation_days' => 'required',
        //     'status' => 'required|string',
        // ];

        return [
            'user_id' => 'required|exists:users,id',
            'book_id' => [
                'required',
                'exists:books,id',
                function ($attribute, $value, $fail) {
                    // Verificar si el libro está disponible para reserva
                    $book = Book::findOrFail($value);
                    if (!$book->is_available_for_reservation()) {
                        $fail('El libro no está disponible actualmente para reserva.');
                    }
                },
            ],
            'reservation_days' => 'required',
            'status' => 'required|string',
        ];
    }
}
