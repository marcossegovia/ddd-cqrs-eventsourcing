<?php

namespace User\Application\Command;

use SimpleBus\Message\Type\Command;
use User\Domain\Model\Email;

class CreateNewUser implements Command
{
    /** @var string */
    private $name;

    /** @var Email */
    private $email;

    public function __construct($a_name, $an_email)
    {
        $this->name  = $a_name;
        $this->email = new Email($an_email);
    }

    /**
     * @return string
     */
    public function name() : string
    {
        return $this->name;
    }

    /**
     * @return Email
     */
    public function email() : Email
    {
        return $this->email;
    }
}
