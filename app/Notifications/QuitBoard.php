<?php

namespace App\Notifications;

use App\Models\Board;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class QuitBoard extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;
    protected $board;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'database',
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
            'board' => $this->board,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'board' => $this->board,
        ];
    }
}
