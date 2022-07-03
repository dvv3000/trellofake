<?php

namespace App\Notifications;

use App\Models\Board;
use App\Models\Card;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCardAssigned extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;
    protected $card;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Card $card)
    {
        $this->card = $card;
        $this->board = $card->task->board;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database',
                'broadcast',
        ];
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
            'card' => $this->card,
            'board' => $this->board,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'card' => "$this->card",
            'board' => "$this->board",
        ]);
    }
}
