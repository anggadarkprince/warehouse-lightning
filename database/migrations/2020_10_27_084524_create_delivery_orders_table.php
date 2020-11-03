<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_number', 30)->unique();
            $table->foreignId('booking_id')->nullable();
            $table->string('type');
            $table->string('destination');
            $table->string('destination_address')->nullable();
            $table->date('delivery_date');
            $table->string('driver_name')->nullable();
            $table->string('vehicle_name')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_plat_number');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_orders');
    }
}
