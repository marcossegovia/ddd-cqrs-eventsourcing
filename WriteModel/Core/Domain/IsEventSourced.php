<?php

namespace Core\Domain;

use Core\Domain\Model\AggregateRoot;

interface IsEventSourced
{
    public static function reconstituteFrom(AggregateRoot $an_aggregate_root, array $some_events);
}
