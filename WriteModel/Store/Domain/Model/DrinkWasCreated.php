<?php

namespace Store\Domain\Model;

use Core\Domain\Model\DomainEvent;

class DrinkWasCreated implements DomainEvent
{
    /** @var DrinkId */
    private $id;

    /** @var string */
    private $name;

    public function __construct(
        DrinkId $a_id,
        string $a_name
    )
    {
        $this->id   = $a_id;
        $this->name = $a_name;
    }

    /**
     * @return DrinkId
     */
    public function aggregateId()
    {
        return $this->id;

    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }
}
