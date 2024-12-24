<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePulsasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pulsas', function (Blueprint $table) {
            $table->id();
            $table->string("nomor");
            $table->string("trx_id");
            $table->string("userID");
            $table->string("code");
            $table->string("price");
            $table->string("response");
            $table->string("callback");
            $table->string("kategori");
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
        Schema::dropIfExists('pulsas');
    }
}
