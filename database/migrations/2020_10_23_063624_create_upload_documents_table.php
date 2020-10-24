<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upload_id');
            $table->foreignId('document_type_id');
            $table->string('document_number');
            $table->date('document_date');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('upload_id')->references('id')->on('uploads')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('document_type_id')->references('id')->on('document_types')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload_documents');
    }
}
