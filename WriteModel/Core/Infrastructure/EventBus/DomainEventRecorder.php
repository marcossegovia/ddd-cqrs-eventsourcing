<?php

namespace Core\Infrastructure\EventBus;

use Core\Domain\Model\DomainEvent;

final class DomainEventRecorder
{
    /** @var DomainEventRecorder */
    private static $instance = null;

    /** @var DomainEvent[] */
    private $messages = [];

    public static function instance()
    {
        if (null === static::$instance)
        {
            static::$instance = new self();
        }

        return static::$instance;
    }

    public function recordMessage(DomainEvent $message)
    {
        $this->messages[] = $message;
    }

    public function recordedMessages()
    {
        return $this->messages;
    }

    public function eraseMessages()
    {
        $this->messages = [];
    }
}
