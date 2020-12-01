<?php

namespace App\Observers;

use App\Models\Booking;

class BookingObserver
{
    /**
     * Handle the booking "creating" event.
     *
     * @param Booking $booking
     * @return void
     */
    public function creating(Booking $booking)
    {
        $booking->booking_number = $booking->getOrderNumber();
    }
}
