<?php

namespace App\Mail;

use App\Models\DemoRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** Automated confirmation sent to the person who booked the demo. */
class DemoRequestReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public DemoRequest $demoRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "We received your SchoolGear demo request ({$this->demoRequest->reference})",
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.demo-request-received');
    }
}
