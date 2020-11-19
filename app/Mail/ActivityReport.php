<?php

namespace App\Mail;

use App\Exports\Exporter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivityReport extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $request;
    private $containers;
    private $goods;

    /**
     * Create a new message instance.
     *
     * @param Request $request
     * @param Collection $containers
     * @param Collection $goods
     */
    public function __construct(Request $request, Collection $containers, Collection $goods)
    {
        $this->request = $request;
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
        return $this->view('view.name');
    }
}
