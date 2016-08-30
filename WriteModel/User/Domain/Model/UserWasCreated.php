<?php

namespace User\Domain\Model;

use Core\Domain\Model\DomainEvent;

class UserWasCreated implements DomainEvent
{
    /** @var UserId */
    private $id;

    /** @var string */
    private $name;

    public function __construct(
        UserId $a_id,
        string $a_name
    )
    {
        $this->id   = $a_id;
        $this->name = $a_name;
    }

    /**
     * @return UserId
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
