<?php

namespace App\Mail;

use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentGradePublished extends Mailable
{
    use SerializesModels;

    public function __construct(
        public User $student,
        public string $schoolName,
        public string $slotLabel,
        public string $gradeName,
        public string $academicYearName,
        public string $publishedByName,
        public CarbonInterface $publishedAt,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "{$this->slotLabel} grades are available on SchoolGear",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.student-grade-published',
            with: [
                'loginUrl' => route('login'),
            ],
        );
    }
}
