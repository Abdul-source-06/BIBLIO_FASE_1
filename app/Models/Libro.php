<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'autor_id', 'descripcion'];

    // Relación con Autor (1 a muchos)
    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }

    // Relación muchos a muchos con Categoría
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_libro');
    }
}
