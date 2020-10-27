<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryOrderContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_order_containers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_order_id');
            $table->foreignId('container_id');
            $table->boolean('is_empty')->default(false);
            $table->string('seal', 50)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('delivery_order_id')->references('id')->on('delivery_orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('container_id')->references('id')->on('containers')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_order_containers');
    }
}
