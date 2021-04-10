<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('coupon_name')->unique();
            $table->unsignedTinyInteger('status')->default(0)->index();
            $table->unsignedTinyInteger('discount');
            $table->unsignedMediumInteger( 'use_count')->default(0);
            $table->unsignedMediumInteger('max_use_count')->default(0);

            $table->dateTime('started_at')->nullable();
            $table->dateTime('expired_at')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
