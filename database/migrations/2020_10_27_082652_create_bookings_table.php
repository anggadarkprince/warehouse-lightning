<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upload_id');
            $table->foreignId('customer_id');
            $table->foreignId('booking_type_id');
            $table->string('booking_number', 30)->unique();
            $table->string('no_reference', 50);
            $table->string('supplier_name')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('shipper_name')->nullable();
            $table->string('voy_flight')->nullable();
            $table->date('arrival_date')->nullable();
            $table->string('tps')->nullable();
            $table->decimal('total_cif', 20, 2)->default(0);
            $table->decimal('total_gross_weight', 20, 2)->default(0);
            $table->decimal('total_weight', 20, 2)->default(0);
            $table->string('xml_file')->nullable();
            $table->string('status')->default('DRAFT');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('upload_id')->references('id')->on('uploads')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('booking_type_id')->references('id')->on('booking_types')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
