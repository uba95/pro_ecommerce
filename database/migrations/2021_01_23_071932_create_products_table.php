<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();

            $table->string('product_name')->unique();
            $table->string('product_slug')->unique();
            $table->string('sku');
            $table->unsignedInteger('product_quantity');
            $table->text('product_details');
            $table->string('product_color');
            $table->string('product_size')->nullable();
            $table->float('product_weight')->unsigned()->nullable();
            $table->float('selling_price')->unsigned();
            
            $table->float('discount_price')->unsigned()->nullable();
            $table->string('video_link')->nullable();
            $table->boolean('main_slider')->nullable();
            $table->boolean('hot_deal')->nullable();
            $table->boolean('best_rated')->nullable();
            $table->boolean('mid_slider')->nullable();
            $table->boolean('hot_new')->nullable();
            $table->boolean('trend')->nullable();
            $table->string('cover')->nullable();
            $table->unsignedTinyInteger('status')->default(0)->index();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
