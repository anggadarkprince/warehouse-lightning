<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSourceIdToBookingDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_containers', function (Blueprint $table) {
            $table->unsignedBigInteger("source_id")->nullable();
            $table->index(["source_id"]);
        });
        Schema::table('booking_goods', function (Blueprint $table) {
            $table->unsignedBigInteger("source_id")->nullable();
            $table->index(["source_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_containers', function (Blueprint $table) {
            $table->dropColumn('source_id');
        });
        Schema::table('booking_goods', function (Blueprint $table) {
            $table->dropColumn('source_id');
        });
    }
}
