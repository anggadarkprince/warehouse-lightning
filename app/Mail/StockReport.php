<?php

namespace App\Mail;

use App\Exports\Exporter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class StockReport extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $stockDate;
    public $containers;
    public $goods;

    /**
     * Create a new message instance.
     *
     * @param string $stockDate
     * @param Collection $containers
     * @param Collection $goods
     */
    public function __construct(string $stockDate, Collection $containers, Collection $goods)
    {
        $this->stockDate = $stockDate;
        $this->containers = $containers;
        $this->goods = $goods;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.reports.stock')
            ->subject('Stock report at ' . $this->stockDate)
            ->attachFromStorage(Exporter::simpleExportToExcel($this->containers, ['title' => 'Container stock']))
            ->attachFromStorage(Exporter::simpleExportToExcel($this->goods, ['title' => 'Goods stock']));
    }
}
