<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  Book extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'author',
        'description',
        'category_id',
    ];


    public function reservations()
    {
        return $this->hasOne(Reservation::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function is_available_for_reservation(): bool
    {
        // Verificar si existe una reserva activa para este libro
        return !$this->reservations()->where('status', 'active')->exists();
    }
}
