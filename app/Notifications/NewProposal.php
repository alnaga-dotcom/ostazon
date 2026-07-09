<?php

namespace App\Notifications;

use App\Models\TutorProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewProposal extends Notification implements ShouldQueue
{
    use Queueable;

    public $proposal;

    public function __construct(TutorProposal $proposal)
    {
        $this->proposal = $proposal;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New proposal for your tutoring request')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Tutor **' . $this->proposal->tutor->name . '** has submitted a proposal for your tutoring request.')
            ->line('Message: ' . ($this->proposal->message ?? 'No message'))
            ->action('View Proposals', url('/student/requests'))
            ->line('Log in to review and accept the proposal.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Proposal',
            'message' => 'Tutor ' . $this->proposal->tutor->name . ' submitted a proposal for your request.',
            'action_url' => '/student/requests',
        ];
    }
}
