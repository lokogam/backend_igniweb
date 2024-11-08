<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
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
        return [
            'user_id' => 'sometimes|required|exists:users,id',
            'book_id' => 'sometimes|required|exists:books,id',
            'status' => 'required|in:Active,Not Active', // Solo se puede cambiar el estado a "Active" o "Not Active"
            'reservation_days' => 'nullable|integer|min:1|max:30', // Solo permitir modificar los días de reserva        
        ];
    }
}
