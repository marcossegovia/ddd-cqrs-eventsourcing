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
     * @return string
     */
    public function aggregateId() : string
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function drinkId() : string
    {
        return $this->drink_id;
    }
}
