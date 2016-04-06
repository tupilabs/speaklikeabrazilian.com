<?php

namespace SLBR\Events;

use SLBR\Events\Event;
use SLBR\Models\Definition;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MediaApprovedEvent extends Event
{
    use SerializesModels;

    public $definition;

    public $template;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Definition $definition, string $template)
    {
        $this->definition = $definition;
        $this->template = $template;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
