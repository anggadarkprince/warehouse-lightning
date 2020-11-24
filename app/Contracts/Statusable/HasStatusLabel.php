<?php


namespace App\Contracts\Statusable;


interface HasStatusLabel
{
    /**
     * Return status label of model.
     *
     * @param null $status
     * @return mixed
     */
    public function getStatusClass($status = null);
}
