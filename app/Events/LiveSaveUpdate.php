<?php

namespace App\Events;

use App\Http\Resources\SimplerSaveResource;
use App\Http\Resources\SimplestUserResource;
use App\Models\Save;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use JetBrains\PhpStorm\ArrayShape;

class LiveSaveUpdate implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;

    public Save $save;

    public string $patches;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $save, $patches)
    {
        $this->user = $user;
        $this->save = $save;
        $this->patches = $patches;
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    #[ArrayShape(["patches" => "string", "save" => "array", "sender" => "array"])] public function broadcastWith(): array
    {
        return [
            "patches" => $this->patches,
            "save" => SimplerSaveResource::make($this->save)->resolve(),
            "sender" => SimplestUserResource::make($this->user)->resolve()
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|PresenceChannel|array
     */
    public function broadcastOn(): Channel|PresenceChannel|array
    {
        return new PresenceChannel("savechannel.".$this->save->id);
    }
}
