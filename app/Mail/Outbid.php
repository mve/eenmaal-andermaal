<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class Outbid extends Mailable
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
        return $this->subject('U bent overboden - EenmaalAndermaal')->view('emails.outbid')->with([
            'title' => $this->title,
            'id' => $this->id,
        ]);
    }
}
