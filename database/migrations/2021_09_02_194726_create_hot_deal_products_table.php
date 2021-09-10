<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotDealProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hot_deal_products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->primary();
            $table->unsignedTinyInteger('status')->default(0)->index();
            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->dateTime('started_at');
            $table->dateTime('expired_at');
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
        Schema::dropIfExists('hot_deal_products');
    }
}
