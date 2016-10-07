<?php

namespace Store\Domain\Model;

use Core\Domain\Model\DomainEvent;
use User\Domain\Model\UserId;

class DrinkWasRated implements DomainEvent
{
    /** @var string */
    private $user_id;

    /** @var string */
    private $drink_id;

    public function __construct(
        UserId $a_user_id,
        DrinkId $a_drink_id
    )
    {
        $this->user_id  = (string) $a_user_id;
        $this->drink_id = (string) $a_drink_id;
    }

    /**
     * @return UserId
     */
    public function aggregateId() : UserId
    {
        return UserId::fromString($this->user_id);
    }

    /**
     * @return DrinkId
     */
    public function drinkId() : DrinkId
    {
        return DrinkId::fromString($this->drink_id);
    }
}
