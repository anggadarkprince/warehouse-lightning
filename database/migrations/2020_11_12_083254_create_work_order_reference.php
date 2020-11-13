<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderReference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_references', function (Blueprint $table) {
            $table->id();
            $table->morphs('reference');
            $table->morphs('source');
            $table->decimal('unit_quantity', 20, 4)->default(0);
            $table->decimal('package_quantity', 20, 4)->default(0);
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
        Schema::dropIfExists('work_order_references');
    }
}
