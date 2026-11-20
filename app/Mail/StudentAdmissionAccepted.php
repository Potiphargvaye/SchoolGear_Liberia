<?php

namespace App\Mail;

use App\Models\Admission;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class StudentAdmissionAccepted extends Mailable
{
    public function __construct(
        public Admission $admission,
        public User $user,
        public string $academicYearName,
        public string $gradeName,
        public string $temporaryPassword,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your SchoolGear student admission has been accepted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.student-admission-accepted',
            with: [
                'schoolName' => $this->admission->school?->school_name,
                'admissionDate' => $this->admission->date_of_admission,
                'loginIdentifier' => $this->user->registration_id ?: $this->user->email,
                'loginIdentifierLabel' => $this->user->registration_id ? 'Registration ID' : 'Account email',
                'loginUrl' => route('login'),
                'passwordResetUrl' => route('password.request'),
            ],
        );
    }
}
