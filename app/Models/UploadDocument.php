<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadDocument extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['id_upload', 'document_type_id', 'document_number', 'document_date', 'description'];

    /**
     * Get the upload of the document.
     */
    public function upload()
    {
        return $this->belongsTo(Upload::class);
    }

    /**
     * Get the document type of the document.
     */
    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    /**
     * Get the files of the document.
     */
    public function uploadDocumentFiles()
    {
        return $this->hasMany(UploadDocumentFile::class);
    }
}
