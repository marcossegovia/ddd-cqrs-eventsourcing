<?php

namespace User\Application\Command;

use SimpleBus\Message\Type\Command;

class CreateNewUser implements Command
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
