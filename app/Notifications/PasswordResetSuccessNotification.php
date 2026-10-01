<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordResetSuccessNotification extends Notification
{
    use Queueable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $school = $this->user->school;
        $schoolName = $school->school_name ?? 'SchoolGear Liberia';

        return (new MailMessage)
            ->subject("Password Reset Successful | {$schoolName}")
            ->view('emails.school-password-reset-success', [
                'user'   => $this->user,
                'school' => $school,
            ]);
    }
}
