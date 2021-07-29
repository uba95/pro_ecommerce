<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('address_id');

            $table->string('payment_method');
            // $table->string('payment_card')->nullable();
            // $table->unsignedSmallInteger('card_last4')->nullable();
            
            $table->float('subtotal_price')->unsigned();
            $table->float('discount_price')->unsigned();
            $table->float('shipping_cost')->unsigned();
            $table->float('total_price')->unsigned();

            $table->unsignedTinyInteger('status')->default(0)->index();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');

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
        Schema::dropIfExists('orders');
    }
}
