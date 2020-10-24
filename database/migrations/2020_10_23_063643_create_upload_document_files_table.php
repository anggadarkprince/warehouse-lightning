<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadDocumentFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_document_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upload_document_id');
            $table->string('src');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('upload_document_id')->references('id')->on('upload_documents')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload_document_files');
    }
}
