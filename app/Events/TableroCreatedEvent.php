<?php

namespace App\Events;

use App\Tableros;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TableroCreatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $name;
    public $autor_id;
    public $user_send_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,Tableros $tablero)
    {
        $this->name = $user->nombres;
        $this->autor_id = $user->id;
        $this->user_send_id = $tablero->usuario_send_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('challenge-kudo-created');
    }
}
