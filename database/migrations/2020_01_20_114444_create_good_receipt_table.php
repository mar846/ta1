<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_receipt', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('receipt_id')->comment('driver');
          $table->foreign('receipt_id')->references('id')->on('receipts');
          $table->unsignedBigInteger('good_id');
          $table->foreign('good_id')->references('id')->on('goods');
          $table->integer('qty');
          $table->string('memo')->nullable();
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
        Schema::dropIfExists('good_receipt');
    }
}
