<?php

namespace Core\Application\Service;

use SimpleBus\Message\Handler\MessageHandler;
use SimpleBus\Message\Message;
use SimpleBus\Message\Recorder\ContainsRecordedMessages;

abstract class WithRecordedEvents implements MessageHandler
{
    /** @var Message[] */
    private $recorded_events = [];

    protected function recordEvents(ContainsRecordedMessages $aggregate)
    {
        foreach($aggregate->recordedMessages() as $message)
        {
            $this->recorded_events[] = $message;
        }
        $aggregate->eraseMessages();
    }

    private function eraseEvents()
    {
        $this->recorded_events = [];
    }

    public function getAllRecordedEvents()
    {
        $recorded_events_to_return = $this->recorded_events;
        $this->eraseEvents();

        return $recorded_events_to_return;
    }
}
