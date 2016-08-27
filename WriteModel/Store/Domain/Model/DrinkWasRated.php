<?php

namespace Store\Domain\Model;

use Core\Domain\Model\DomainEvent;

class DrinkWasRated implements DomainEvent
{
    /** @var string */
    private $user_id;

    /** @var string */
    private $drink_id;

    public function __construct(
        $a_user_id,
        $a_drink_id
    )
    {
        $this->user_id  = $a_user_id;
        $this->drink_id = $a_drink_id;
    }

    /**
     * @return string
     */
    public function aggregateId()
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function drinkId()
    {
        return $this->drink_id;
    }
}
