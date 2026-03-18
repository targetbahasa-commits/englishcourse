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
    public ?string $targetPath;
    public ?string $targetTitle;

    protected int $targetId;

    public function __construct(int $targetId, int $fromId, string $fromName, ?string $targetPath = null, ?string $targetTitle = null)
    {
        $this->targetId = $targetId;
        $this->fromId = $fromId;
        $this->fromName = $fromName;
        $this->targetPath = $targetPath;
        $this->targetTitle = $targetTitle;
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
