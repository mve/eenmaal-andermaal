<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class AuctionEnding extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;
    protected $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $id)
    {
        $this->title = $title;
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.auction_ending')->subject('Een veiling waarop u heeft geboden is bijna afgelopen - EenmaalAndermaal')->with([
            'title' => $this->title,
            'id' => $this->id,
        ]);
    }
}
