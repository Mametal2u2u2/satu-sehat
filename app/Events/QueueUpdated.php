<?php

namespace App\Events;

use App\Models\Visit;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QueueUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $visit;

    /**
     * Create a new event instance.
     */
    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Broadcast ke channel publik antrian klinik/branch tertentu
        return [
            new Channel('queue.branch.' . $this->visit->branch_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'queue_number' => $this->visit->queue_number,
            'doctor_id'    => $this->visit->doctor_id,
            'status'       => $this->visit->status,
        ];
    }
}
