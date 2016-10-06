<?php

namespace User\Domain\Model;

use Core\Domain\Model\DomainEvent;

final class UserWasCreated implements DomainEvent
{
    /** @var UserId */
    private $id;

    /** @var string */
    private $name;

    /** @var Email */
    private $email;

    public function __construct(
        UserId $a_id,
        string $a_name,
        Email $an_email
    )
    {
        $this->id   = $a_id;
        $this->name = $a_name;
        $this->email = $an_email;
    }

    /**
     * @return UserId
     */
    public function aggregateId()
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

    /**
     * @return Email
     */
    public function email()
    {
        return $this->email;
    }
}
