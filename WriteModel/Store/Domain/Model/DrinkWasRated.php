<?php

namespace Store\Domain\Model;

use SimpleBus\Message\Type\Event;

class DrinkWasRated implements Event
{
    /** @var string */
    private $drink_id;
    
    /** @var string */
    private $user_id;

    public function __construct(
        $a_drink_id,
        $a_user_id
    )
    {
        $this->drink_id = $a_drink_id;
        $this->user_id = $a_user_id;
    }

    /**
     * @return string
     */
    public function drinkId()
    {
        return $this->drink_id;
    }

    /**
     * @return string
     */
    public function userId()
    {
        return $this->user_id;
    }

    
}
