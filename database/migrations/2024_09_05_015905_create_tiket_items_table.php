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
        Schema::create('tiket_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_fasilitas');
            $table->foreignId('id_tiket');
            $table->integer('jumlah');
            $table->timestamps();

            $table->foreign('id_fasilitas')->references('id')->on('fasilitas');
            $table->foreign('id_tiket')->references('id')->on('tiket');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiket_items');
    }
};
