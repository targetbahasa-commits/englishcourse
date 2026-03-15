<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RemoteScreenRequested implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $fromId;
    public string $fromName;

    protected int $targetId;

    public function __construct(int $targetId, int $fromId, string $fromName)
    {
        $this->targetId = $targetId;
        $this->fromId = $fromId;
        $this->fromName = $fromName;
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('remote-view.' . $this->targetId)];
    }

    public function broadcastAs(): string
    {
        return 'RemoteScreenRequested';
    }
}
