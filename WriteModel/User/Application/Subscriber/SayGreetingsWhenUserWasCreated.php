<?php

namespace User\Application\Subscriber;

use Core\Application\Subscriber\ApplicationSubscriber;
use SimpleBus\Message\Bus\MessageBus;
use User\Application\Command\SayGreetings;
use User\Domain\Model\UserWasCreated;

final class SayGreetingsWhenUserWasCreated implements ApplicationSubscriber
{
    /** @var MessageBus */
    private $command_bus;

    public function __construct(MessageBus $a_command_bus)
    {
        $this->command_bus = $a_command_bus;
    }

    public function __invoke(UserWasCreated $event)
    {
        $greetings_command = new SayGreetings($event->name(), $event->email());
        $this->command_bus->handle($greetings_command);
    }
}
