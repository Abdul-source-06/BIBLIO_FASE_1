<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaLibroTable extends Migration
{
    public function up(): void
    {
        Schema::create('categoria_libro', function (Blueprint $table) {
            $table->foreignId('categoria_id')->constrained()->onDelete('cascade');
            $table->foreignId('libro_id')->constrained()->onDelete('cascade');
            $table->primary(['categoria_id', 'libro_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categoria_libro');
    }
}
