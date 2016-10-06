<?php

namespace User\Application\Command;

use SimpleBus\Message\Type\Command;

final class SayGreetings implements Command
{
    /** @var string */
    private $name;

    /** @var string */
    private $email;

    public function __construct(string $a_name, string $an_email)
    {
        $this->name  = $a_name;
        $this->email = $an_email;
    }

    /**
     * @return string
     */
    public function name() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function email() : string
    {
        return $this->email;
    }

}
