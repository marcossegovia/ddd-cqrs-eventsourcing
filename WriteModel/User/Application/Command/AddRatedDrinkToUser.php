<?php

namespace User\Application\Command;

use SimpleBus\Message\Type\Command;

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
     * @return string
     */
    public function drinkId() : string
    {
        return $this->drink_id;
    }

    /**
     * @return string
     */
    public function userId() : string
    {
        return $this->user_id;
    }
}
