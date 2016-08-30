<?php

namespace Store\Domain\Model;

use Core\Domain\Model\DomainEvent;
use User\Domain\Model\UserId;

class DrinkWasRated implements DomainEvent
{
    /** @var UserId */
    private $user_id;

    /** @var DrinkId */
    private $drink_id;

    public function __construct(
        UserId $a_user_id,
        DrinkId $a_drink_id
    )
    {
        $this->user_id  = $a_user_id;
        $this->drink_id = $a_drink_id;
    }

    /**
     * @return UserId
     */
    public function aggregateId()
    {
        return $this->user_id;
    }

    /**
     * @return DrinkId
     */
    public function drinkId()
    {
        return $this->drink_id;
    }
}
