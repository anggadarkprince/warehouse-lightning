<?php

namespace App\Observers;

use App\Models\Upload;

class UploadObserver
{
    /**
     * Handle the upload "creating" event.
     *
     * @param Upload $upload
     * @return void
     */
    public function creating(Upload $upload)
    {
        $upload->upload_number = $upload->getOrderNumber();
    }
}
