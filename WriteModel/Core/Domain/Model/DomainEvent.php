<?php

namespace Core\Domain\Model;

use SimpleBus\Message\Type\Event;

interface DomainEvent extends Event
{
    public function aggregateId();
}
