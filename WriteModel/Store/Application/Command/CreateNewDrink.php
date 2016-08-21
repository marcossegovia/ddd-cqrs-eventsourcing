<?php

namespace Store\Application\Command;

use SimpleBus\Message\Type\Command;

final class CreateNewDrink implements Command
{
    /** @var string */
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }
}
