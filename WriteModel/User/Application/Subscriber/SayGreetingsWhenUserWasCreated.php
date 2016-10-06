<?php

namespace User\Application\Subscriber;

use SimpleBus\Message\Bus\MessageBus;
use SimpleBus\Message\Message;
use SimpleBus\Message\Subscriber\MessageSubscriber;
use User\Application\Command\SayGreetings;
use User\Domain\Model\UserWasCreated;

final class SayGreetingsWhenUserWasCreated implements MessageSubscriber
{
    /** @var MessageBus */
    private $command_bus;

    public function __construct(MessageBus $a_command_bus)
    {
        $this->command_bus = $a_command_bus;
    }

    public function notify(Message $message)
    {
        if ($message instanceof UserWasCreated)
        {
            $greetings_command = new SayGreetings($message->name(), $message->email());
            $this->command_bus->handle($greetings_command);
        }
    }
}
