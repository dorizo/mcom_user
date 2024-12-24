<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Harga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('hargas', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('category');
            $table->string('brand');
            $table->String('type');
            $table->String('seller_name');
            $table->integer('price');
            $table->String('buyer_sku_code');
            $table->String('buyer_product_status');
            $table->String('seller_product_status');
            $table->String('stock');
            $table->String('multi');
            $table->String('start_cut_off');
            $table->String('end_cut_off');
            $table->String('desc');
            $table->integer('member');
            $table->integer('warung');
            $table->integer('konter');
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
        //
        Schema::dropIfExists('hargas');
    }
}
