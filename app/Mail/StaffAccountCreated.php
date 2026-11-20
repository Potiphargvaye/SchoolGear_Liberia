<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class StaffAccountCreated extends Mailable
{
    public function __construct(
        public User $user,
        public string $roleName,
        private string $temporaryPassword,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your SchoolGear account details',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.staff-account-created',
            with: [
                'schoolName' => $this->user->school?->school_name,
                'temporaryPassword' => $this->temporaryPassword,
                'loginUrl' => route('login'),
                'passwordResetUrl' => route('password.request'),
            ],
        );
    }
}
