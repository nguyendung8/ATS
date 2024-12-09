<?php

namespace App\Notifications;

use App\Mail\SendNotificationMail;
use App\Models\Candidate;
use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;

class RejectCandidate extends Notification implements ShouldQueue
{
    use Queueable;

    protected Candidate $candidate;
    protected $mail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Candidate $candidate, $mail)
    {
        $this->candidate = $candidate;
        $this->mail = $mail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return Mailable
     */
    public function toMail($notifiable)
    {
        return (new SendNotificationMail($this->mail->title, $this->mail->content))
            ->to(optional($this->candidate->user)->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }
}
