<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('billTo');
            $table->foreign('billTo')->references('id')->on('addresses');
            $table->unsignedBigInteger('shipTo');
            $table->foreign('shipTo')->references('id')->on('addresses');
            $table->string('so');
            $table->string('reference');
            $table->date('referenceDate');
            $table->bigInteger('total');
            $table->date('validTill');
            $table->string('paymentTerms');
            $table->string('deliveryTime');
            $table->string('downPayment');
            $table->integer('version');
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('supervisor_id')->nullable();;
            $table->foreign('supervisor_id')->references('id')->on('users');
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
        Schema::dropIfExists('sales');
    }
}
