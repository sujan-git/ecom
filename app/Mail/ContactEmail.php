<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->data = $request->except('_token');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return $this->view('mail.contact')
            // ->attachData($this->pdf, 'test.pdf', ['mime' => 'application/pdf'])
            ->with('data', $this->data);

    }
}
