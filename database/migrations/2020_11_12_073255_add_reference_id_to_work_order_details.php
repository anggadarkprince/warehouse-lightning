<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceIdToWorkOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_order_containers', function (Blueprint $table) {
            $table->tinyInteger('multiplier')->after('seal')->default(1);
        });
        Schema::table('work_order_goods', function (Blueprint $table) {
            $table->tinyInteger('multiplier')->after('goods_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_order_containers', function (Blueprint $table) {
            $table->dropColumn('multiplier');
        });
        Schema::table('work_order_goods', function (Blueprint $table) {
            $table->dropColumn('multiplier');
        });
    }
}
