<?php

namespace App\Mail;

use App\Models\School;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewSchoolRegistrationAlert extends Mailable
{
    use SerializesModels;

    public function __construct(
        public School $school,
        public User $owner,
        public bool $createdByAdmin = false,
        public ?string $createdByName = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New SchoolGear registration: {$this->school->school_name}",
            replyTo: [new Address($this->owner->email, $this->owner->name)],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-school-registration-alert',
            with: [
                'createdByAdmin' => $this->createdByAdmin,
                'createdByName' => $this->createdByName,
            ],
        );
    }
}
