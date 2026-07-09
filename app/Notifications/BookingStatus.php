<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingStatus extends Notification implements ShouldQueue
{
    use Queueable;

    public $booking;
    public $status;

    public function __construct(Booking $booking, $status)
    {
        $this->booking = $booking;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $subject = match($this->status) {
            'new' => 'New lesson booking',
            'confirmed' => 'Lesson booking confirmed',
            'cancelled' => 'Lesson booking cancelled',
            'completed' => 'Lesson completed',
            default => 'Booking status update',
        };

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your lesson booking #' . $this->booking->id . ' is now **' . $this->status . '**.')
            ->action('View Booking', url('/' . ($notifiable->isTutor() ? 'tutor' : 'student') . '/bookings'))
            ->line('Thank you for using OstazON!');
    }

    public function toDatabase($notifiable)
    {
        $statusLabels = [
            'new' => 'New Booking',
            'confirmed' => 'Booking Confirmed',
            'cancelled' => 'Booking Cancelled',
            'completed' => 'Lesson Completed',
        ];

        return [
            'title' => $statusLabels[$this->status] ?? 'Booking Update',
            'message' => 'Booking #' . $this->booking->id . ' is now ' . $this->status . '.',
            'action_url' => '/' . ($notifiable->isTutor() ? 'tutor' : 'student') . '/bookings',
        ];
    }
}
