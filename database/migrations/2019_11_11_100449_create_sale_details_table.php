<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('sale_details', function (Blueprint $table) {
        //   $table->unsignedBigInteger('sale_id');
        //   $table->foreign('sale_id')->references('id')->on('sales');
        //   $table->unsignedBigInteger('good_id');
        //   $table->foreign('good_id')->references('id')->on('goods');
        //   $table->integer('qty');
        //   $table->integer('price');
        //   $table->integer('subtotal');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_details');
    }
}
