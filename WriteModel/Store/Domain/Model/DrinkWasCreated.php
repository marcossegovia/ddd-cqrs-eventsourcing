<?php

namespace Store\Domain\Model;

use SimpleBus\Message\Type\Event;

class DrinkWasCreated implements Event
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    public function __construct(
        $a_id,
        $a_name
    )
    {
        $this->id   = $a_id;
        $this->name = $a_name;
    }

    /**
     * @return string
     */
    public function id()
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
