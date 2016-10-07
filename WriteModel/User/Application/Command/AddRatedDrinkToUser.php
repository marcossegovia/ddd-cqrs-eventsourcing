<?php

namespace User\Application\Command;

use SimpleBus\Message\Type\Command;
use Store\Domain\Model\DrinkId;
use User\Domain\Model\UserId;

final class AddRatedDrinkToUser implements Command
{
    /** @var string */
    private $drink_id;

    /** @var string */
    private $user_id;

    public function __construct(
        string $a_drink_id,
        string $a_user_id
    )
    {
        $this->drink_id = $a_drink_id;
        $this->user_id  = $a_user_id;
    }

    /**
     * @return DrinkId
     */
    public function drinkId() : DrinkId
    {
        return DrinkId::fromString($this->drink_id);
    }

    /**
     * @return UserId
     */
    public function userId() : UserId
    {
        return UserId::fromString($this->user_id);
    }
}
