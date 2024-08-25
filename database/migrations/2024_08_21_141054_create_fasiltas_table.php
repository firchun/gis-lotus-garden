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
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('foto');
            $table->string('nama');
            $table->string('slug');
            $table->text('keterangan');
            $table->string('latitude');
            $table->string('longitude');
            $table->enum('type', ['Berbayar', 'Gratis']);
            $table->string('harga')->nullable();
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
        Schema::dropIfExists('fasiltas');
    }
};
