<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Mirrors RemoteScreenRequested (same channel, same shape) but for a fresh
 * "ring" - unlike a screen-share request this is never scoped to a specific
 * target_path (a voice call should ring the student wherever they currently
 * are), and student-broadcaster.blade.php's tab-arming gate never applies
 * to it - see AudioCallController::requestCall().
 */
class RemoteAudioCallRequested implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $fromId;
    public string $fromName;

    protected int $targetId;

    public function __construct(int $targetId, int $fromId, string $fromName)
    {
        $this->targetId = $targetId;
        $this->fromId   = $fromId;
        $this->fromName = $fromName;
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('remote-view.' . $this->targetId)];
    }

    public function broadcastAs(): string
    {
        return 'RemoteAudioCallRequested';
    }
}
