<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_bereal');
            $table->foreign('id_bereal')->references('id')->on('bereal')->onDelete('cascade');
            $table->unsignedBigInteger('id_usuari');
            $table->foreign('id_usuari')->references('id')->on('users')->onDelete('cascade');
            $table->text('comentario');
            $table->timestamp('hora')->useCurrent(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
};
