<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnOrderRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_order_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('billing_address_id');
            $table->unsignedBigInteger('shipping_address_id');

            $table->string('reason');
            $table->text('details')->nullable();

            $table->string('payment_method');
            $table->string('courier');
            $table->float('shipping_cost')->unsigned();
            
            $table->unsignedTinyInteger('status')->default(0)->index();
            
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('billing_address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('shipping_address_id')->references('id')->on('addresses')->onDelete('cascade');

            $table->dateTime('shipping_started_at')->nullable();
            $table->dateTime('shipping_returned_at')->nullable();
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
        Schema::dropIfExists('return_order_requests');
    }
}
