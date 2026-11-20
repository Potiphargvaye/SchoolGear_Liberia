<?php

namespace App\Mail;

use App\Models\School;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SchoolRegistrationConfirmation extends Mailable
{
    use SerializesModels;

    public function __construct(
        public School $school,
        public User $owner,
        public bool $createdByAdmin = false,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your SchoolGear account is ready  {$this->school->school_name}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.school-registration-confirmation',
            with: [
                'loginUrl' => route('login'),
                'createdByAdmin' => $this->createdByAdmin,
            ],
        );
    }
}
