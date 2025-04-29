<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    // Relación muchos a muchos con Libro
    public function libros()
    {
        return $this->belongsToMany(Libro::class, 'categoria_libro');
    }
}
