<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_goods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id');
            $table->foreignId('goods_id');
            $table->decimal('unit_quantity', 20, 4)->default(0);
            $table->decimal('package_quantity', 20, 4)->default(0);
            $table->decimal('weight', 20, 4)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('goods_id')->references('id')->on('goods')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_goods');
    }
}
