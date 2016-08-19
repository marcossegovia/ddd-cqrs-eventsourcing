<?php

namespace Core\Application\Service;

use SimpleBus\Message\Bus\MessageBus;
use SimpleBus\Message\Handler\MessageHandler;
use SimpleBus\Message\Message;

final class WithEventHandling implements MessageHandler
{
    private $application_service_with_events;

    /** @var */
    private $event_bus;

    public function __construct(
        WithRecordedEvents $an_application_service_with_events_recorded,
        MessageBus $an_event_bus
    )
    {
        $this->application_service_with_events = $an_application_service_with_events_recorded;
        $this->event_bus                       = $an_event_bus;
    }

    /**
     * Handles the given message.
     *
     * @param Message $message
     *
     * @return void
     */
    public function handle(Message $message)
    {
        $this->application_service_with_events->handle($message);
        $this->publishApplicationServiceEvents();
    }

    private function publishApplicationServiceEvents()
    {
        $recorded_events = $this->application_service_with_events->getAllRecordedEvents();
        foreach ($recorded_events as $event)
        {
            $this->event_bus->handle($event);
        }
    }
}
