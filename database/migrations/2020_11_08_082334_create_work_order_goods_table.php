<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_goods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id');
            $table->foreignId('goods_id');
            $table->decimal('unit_quantity', 20, 4)->default(0);
            $table->decimal('package_quantity', 20, 4)->default(0);
            $table->decimal('weight', 20, 4)->default(0);
            $table->decimal('gross_weight', 20, 4)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('work_order_id')->references('id')->on('work_orders')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('work_order_goods');
    }
}
