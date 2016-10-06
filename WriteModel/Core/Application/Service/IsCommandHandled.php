<?php

namespace Core\Application\Service;

use SimpleBus\Message\Handler\MessageHandler;
use SimpleBus\Message\Message;

final class IsCommandHandled implements MessageHandler
{
    /** @var ApplicationService */
    private $application_service;

    public function __construct(
        ApplicationService $an_application_service
    )
    {
        $this->application_service = $an_application_service;
    }

    public function handle(Message $message)
    {
        $application_service_response = call_user_func([$this->application_service, '__invoke'], $message);

        return $application_service_response;
    }
}
