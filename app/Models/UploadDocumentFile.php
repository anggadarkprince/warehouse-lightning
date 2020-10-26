<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadDocumentFile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['src', 'file_name'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    /**
     * Get the document of the file.
     */
    public function uploadDocument()
    {
        return $this->belongsTo(UploadDocument::class);
    }
}
