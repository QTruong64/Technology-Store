<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $subjectMail, $viewMail, $array;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subjectMail, $viewMail, $array)
    {
        $this->subjectMail = $subjectMail;
        $this->array = $array;
        $this->viewMail = $viewMail;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        $mailFrom = $this->array['status'] == 0 ? $this->array['email'] : env('MAIL_FROM_ADDRESS');
        return new Envelope(
            from: new Address($mailFrom, $this->subjectMail),
            subject: $this->subjectMail,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: $this->viewMail,
            with: [
                'array' => $this->array,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
