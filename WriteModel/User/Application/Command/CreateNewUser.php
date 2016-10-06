<?php

namespace User\Application\Command;

use SimpleBus\Message\Type\Command;

class CreateNewUser implements Command
{
    /** @var string */
    private $name;

    /** @var string */
    private $email;

    public function __construct($a_name, $an_email)
    {
        $this->name  = $a_name;
        $this->email = $an_email;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function email()
    {
        return $this->email;
    }
}
