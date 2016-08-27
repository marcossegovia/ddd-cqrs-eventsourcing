<?php

namespace Core\Infrastructure\EventStore\InMemory;

use Core\Domain\Model\AggregateRoot;
use SimpleBus\Message\Recorder\ContainsRecordedMessages;

final class EventStore
{
    private $events = [];

    public function add(ContainsRecordedMessages $an_aggregate)
    {
        foreach ($an_aggregate->recordedMessages() as $event)
        {
            $this->events[$an_aggregate->id()->__toString()][] = $event;
        }
        $an_aggregate->eraseMessages();
    }

    public function retrieveEventsFrom(AggregateRoot $an_aggregate_root)
    {
        return $this->events[$an_aggregate_root->__toString()];
    }
}
