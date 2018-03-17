<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResourceUpdated extends Notification
{
    use Queueable;

    protected $user;

    protected $resource;

    protected $redirect_to;

    protected $badge;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $resource, $redirect_to, $badge = []) 
    {
        $this->user = $user;
        $this->resource = $resource;
        $this->redirect_to = $redirect_to;
        $this->badge = $badge;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'subject' => $this->user->full_name.' has updated the '.class_basename($this->resource).': '.$this->resource->name,
            'redirect_to' => url($this->redirect_to),
            'has_badge' => count($this->badge) ? 1 : 0,
            'badge' => [
                'text' => isset($this->badge['text']) ? $this->badge['text'] : '',
                'class' => isset($this->badge['class']) ? $this->badge['class'] : ''
            ]
        ];
    }
}
