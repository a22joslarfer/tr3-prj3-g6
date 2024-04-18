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
        Schema::create('bereal', function (Blueprint $table) {
            $table->id();
            $table->binary('img_del')->nullable();
            $table->binary('img_tra')->nullable();
            $table->unsignedBigInteger('id_usuari');
            $table->foreign('id_usuari')->references('id')->on('usuarios')->onDelete('cascade');
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
        Schema::dropIfExists('bereal');
    }
};
