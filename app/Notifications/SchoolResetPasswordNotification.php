<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SchoolResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $school = $notifiable->school; // null for the Platform Admin
        $schoolName = $school->school_name ?? 'SchoolGear Liberia';

        return (new MailMessage)
            ->subject("Password Reset | {$schoolName}")
            ->view('emails.school-reset-password', [
                'user'   => $notifiable,
                'school' => $school,
                'url'    => $url,
            ]);
    }
}
