<?php

namespace User\Application\Command;

use MarcosSegovia\User\Domain\Model\UserId;
use SimpleBus\Message\Type\Command;
use Store\Domain\Model\DrinkId;

final class AddRatedDrinkToUser implements Command
{
    /** @var DrinkId */
    private $drink_id;

    /** @var UserId */
    private $user_id;

    public function __construct(
        string $a_drink_id,
        string $a_user_id
    )
    {
        $this->drink_id = DrinkId::fromString($a_user_id);
        $this->user_id  = UserId::fromString($a_user_id);
    }

    /**
     * @return DrinkId
     */
    public function drink_id() : DrinkId
    {
        return $this->drink_id;
    }

    /**
     * @return UserId
     */
    public function user_id() : UserId
    {
        return $this->user_id;
    }
}
