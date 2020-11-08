<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_containers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id');
            $table->foreignId('container_id');
            $table->boolean('is_empty')->default(false);
            $table->string('seal', 50)->nullable();
            $table->integer('quantity')->default(1);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('work_order_id')->references('id')->on('work_orders')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('work_order_containers');
    }
}
