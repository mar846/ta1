<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('purchase_details', function (Blueprint $table) {
        //   $table->unsignedBigInteger('purchase_id');
        //   $table->foreign('purchase_id')->references('id')->on('purchases');
        //   $table->unsignedBigInteger('good_id');
        //   $table->foreign('good_id')->references('id')->on('goods');
        //   $table->integer('qty');
        //   $table->double('price');
        //   $table->double('subtotal');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_details');
    }
}
