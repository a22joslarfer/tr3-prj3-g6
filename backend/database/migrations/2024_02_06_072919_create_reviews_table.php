<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->unsignedBigInteger('disco_id');
            $table->foreign('disco_id')->references('id')->on('discotecas')->onDelete('cascade');
            $table->string('titulo');
            $table->text('content');
            $table->integer('likes')->default(0);
            $table->integer('dislikes')->default(0);
            $table->string('photo')->nullable();
            $table->unsignedInteger('puntuacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');

    }
};
