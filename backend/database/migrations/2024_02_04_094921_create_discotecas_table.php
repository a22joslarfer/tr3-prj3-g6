<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('discotecas');
        
        Schema::create('discotecas', function (Blueprint $table) {
            $table->id();
            $table->json('coordenadas');
            $table->string('imgUrl');
            $table->integer('minEdad');
            $table->string('horario');
            $table->string('nombre_local');
            $table->string('telefono');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discotecas');
    }
};