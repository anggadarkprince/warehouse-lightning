<?php


namespace App\Contracts\Numerable;


interface HasOrderNumber
{
    /**
     * Return generated order number or model.
     *
     * @return mixed
     */
    public function getOrderNumber();
}
