<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPageItemsTable extends Migration
{
    /**s
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_page_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->nullable();
    
            $table->string('main_banner_text')->nullable();
            $table->string('main_banner_img')->nullable();
    
            $table->text('banner_slider_text')->nullable();
            $table->string('banner_slider_img')->nullable();
    
            $table->string('advert_headline')->nullable();
            $table->string('advert_text')->nullable();
            $table->string('advert_img')->nullable();
            
            $table->boolean('is_main_banner')->nullable();
            $table->boolean('is_banner_slider')->nullable();
            $table->boolean('is_advert')->nullable();
            $table->unsignedTinyInteger('status')->default(0)->index();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

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
        Schema::dropIfExists('landing_page_items');
    }
}
