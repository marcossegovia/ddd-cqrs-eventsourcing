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
     * @return UserId
     */
    public function aggregateId() : UserId
    {
        return UserId::fromString($this->id);
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
        return new Email($this->email);
    }
}
