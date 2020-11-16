<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTakeStockContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('take_stock_containers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('take_stock_id');
            $table->foreignId('booking_id');
            $table->foreignId('container_id');
            $table->boolean('is_empty')->default(false);
            $table->string('seal', 50)->nullable();
            $table->integer('quantity')->default(1);
            $table->text('description')->nullable();
            $table->integer('revision_quantity')->default(1);
            $table->text('revision_description')->nullable();
            $table->timestamps();

            $table->foreign('take_stock_id')->references('id')->on('take_stocks')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('booking_id')->references('id')->on('bookings')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('take_stock_containers');
    }
}
