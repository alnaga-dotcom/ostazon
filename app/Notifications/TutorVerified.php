<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TutorVerified extends Notification implements ShouldQueue
{
    use Queueable;

    public $level;

    public function __construct($level)
    {
        $this->level = $level;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your OstazON tutor account has been verified')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Congratulations! Your tutor account has been verified as **' . strtoupper($this->level) . '**.')
            ->line('You can now start receiving student bookings and teaching on OstazON.')
            ->action('Go to Dashboard', url('/tutor/dashboard'))
            ->line('Thank you for joining OstazON!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Account Verified',
            'message' => 'Your tutor account has been verified as ' . strtoupper($this->level) . '.',
            'action_url' => '/tutor/dashboard',
        ];
    }
}
