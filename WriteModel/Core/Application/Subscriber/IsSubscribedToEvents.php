<?php

namespace Core\Application\Subscriber;

use SimpleBus\Message\Message;
use SimpleBus\Message\Subscriber\MessageSubscriber;

final class IsSubscribedToEvents implements MessageSubscriber
{
    /** @var ApplicationSubscriber */
    private $application_service;

    public function __construct(
        ApplicationSubscriber $an_application_subscriber
    )
    {
        $this->application_service = $an_application_subscriber;
    }

    public function notify(Message $message)
    {
        $application_service_response = call_user_func([$this->application_service, '__invoke'], $message);

        return $application_service_response;
    }
}
