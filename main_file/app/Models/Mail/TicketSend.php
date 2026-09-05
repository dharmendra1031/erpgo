<?php

namespace App\Models\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketSend extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($support)
    {
        $this->ticket = $support;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        //dd( $this->ticket);
        return $this->view('email.ticket_send')->with('ticket', $this->ticket)->subject('Ragarding to employee ticket generated.');
    }
}
