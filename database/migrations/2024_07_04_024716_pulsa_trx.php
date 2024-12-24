<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PulsaTrx extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('pulsaTrx', function (Blueprint $table) {
            $table->id();
            $table->string("sn");
            $table->string("trx_id");
            $table->text("response");
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
        
        Schema::dropIfExists('pulsaTrx');
        //
        
    }
}
