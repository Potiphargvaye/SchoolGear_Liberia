<?php

namespace App\Mail;

use App\Models\DemoRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/** Alert sent to the platform owner when a new request comes in. */
class DemoRequestAdminAlert extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public DemoRequest $demoRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New demo request: {$this->demoRequest->school_name} ({$this->demoRequest->reference})",
            // Hitting "Reply" writes straight back to the requester.
            replyTo: [new Address($this->demoRequest->email, $this->demoRequest->full_name)],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.demo-request-admin-alert');
    }
}
