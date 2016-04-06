<?php

namespace SLBR\Events;

use SLBR\Events\Event;
use SLBR\Models\Definition;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MediaApprovedEvent extends Event
{
    use SerializesModels;

    public $email;
    public $text;
    public $contributor;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($email, $text, $contributor)
    {
        $this->email = $email;
        $this->text = $text;
        $this->contributor = $contributor;
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
