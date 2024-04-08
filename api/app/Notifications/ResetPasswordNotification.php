<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $_notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $_notifiable): MailMessage
    {
        $url = env('FRONT_APP_URL', 'http://localhost:3000') . '/public/reset-password?token=' . $this->token;

        return (new MailMessage())
            ->line('You are receiving this e-mail because we have received a request to reset your password.')
            ->action('Reset password', $url)
            ->line('If you have not requested a password reset, no further action is required.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $_notifiable): array
    {
        return [
            'token' => $this->token,
        ];
    }
}
