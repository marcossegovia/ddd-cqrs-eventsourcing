<?php

namespace Core\Domain\Infrastructure;

use Core\Domain\Model\AggregateRoot;

interface EventStore
{
    public function getEventsFrom(AggregateRoot $an_aggregate_root);
}
