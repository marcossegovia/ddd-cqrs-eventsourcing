<?php

namespace User\Domain\Model;

use Core\Domain\Model\DomainEvent;

final class UserWasCreated implements DomainEvent
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    public function __construct(
        UserId $a_id,
        string $a_name,
        Email $an_email
    )
    {
        $this->id    = (string) $a_id;
        $this->name  = $a_name;
        $this->email = $an_email->value();
    }

    /**
     * @return string
     */
    public function aggregateId() : string
    {
        return $this->id;
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
