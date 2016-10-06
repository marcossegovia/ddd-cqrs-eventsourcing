<?php

namespace Core\Application\Service;

use Core\Domain\Infrastructure\EventBus;
use Core\Infrastructure\EventBus\DomainEventRecorder;
use SimpleBus\Message\Bus\MessageBus;
use SimpleBus\Message\Handler\MessageHandler;
use SimpleBus\Message\Message;

final class WithEventHandling implements MessageHandler
{
    /** @var ApplicationService */
    private $application_service;

    /** @var EventBus */
    private $event_bus;

    public function __construct(
        ApplicationService $an_application_service,
        MessageBus $an_event_bus
    )
    {
        $this->application_service = $an_application_service;
        $this->event_bus           = $an_event_bus;
    }

    public function handle(Message $message)
    {
        $application_service_response = call_user_func([$this->application_service, '__invoke'], $message);
        $this->publishApplicationServiceEvents();

        return $application_service_response;
    }

    private function publishApplicationServiceEvents()
    {
        $recorded_messages = DomainEventRecorder::instance()->recordedMessages();
        DomainEventRecorder::instance()->eraseMessages();

        array_map([$this, 'handleEvent'], $recorded_messages);
    }

    private function handleEvent($event)
    {
        $this->event_bus->handle($event);
    }
}
