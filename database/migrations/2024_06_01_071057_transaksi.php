<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('Transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('userID');
            $table->string('Trx_ID');
            $table->integer('saldo');
            $table->String('responseData');
            $table->String('status');
            $table->rememberToken();
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
        //]
        Schema::dropIfExists('Transaksi');
    }
}
