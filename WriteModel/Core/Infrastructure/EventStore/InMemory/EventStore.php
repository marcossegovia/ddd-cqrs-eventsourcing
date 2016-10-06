<?php

namespace Core\Infrastructure\EventStore\InMemory;

use Core\Domain\Model\AggregateRoot;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;
use SimpleBus\Message\Message;
use Core\Domain\Infrastructure\EventStore as EventStoreInterface;

final class EventStore implements MessageBusMiddleware, EventStoreInterface
{
    /** @var array */
    private $events = [];

    /**
     * The provided $next callable should be called whenever the next middleware should start handling the message.
     * Its only argument should be a Message object (usually the same as the originally provided message).
     *
     * @param Message  $message
     * @param callable $next
     *
     * @return void
     */
    public function handle(
        Message $message,
        callable $next
    )
    {
        $this->events[$message->aggregateId()][] = $message;
        $next($message);
    }

    public function getEventsFrom(AggregateRoot $an_aggregate_root)
    {
        return $this->events[$an_aggregate_root->__toString()];
    }
}
