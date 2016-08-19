<?php

namespace MarcosSegovia\User\Domain\Model;

use SimpleBus\Message\Recorder\ContainsRecordedMessages;
use SimpleBus\Message\Recorder\PrivateMessageRecorderCapabilities;
use Store\Domain\Model\DrinkId;
use Store\Domain\Model\DrinkWasRated;
use User\Domain\Model\UserWasCreated;

class User implements ContainsRecordedMessages
{
    use PrivateMessageRecorderCapabilities;

    const IS_NEW = 'is_new';

    /** @var UserId */
    private $id;

    /** @var string */
    private $name;

    /** @var array */
    private $rated_drinks;

    public function __construct(
        UserId $an_id,
        string $a_name,
        array $some_rated_drinks,
        string $is_new
    )
    {
        $this->id           = $an_id;
        $this->name         = $a_name;
        $this->rated_drinks = $some_rated_drinks;

        if (self::IS_NEW === $is_new)
        {
            $this->record(new UserWasCreated($an_id, $a_name));
        }
    }

    public static function create(
        UserId $an_id,
        string $a_name
    )
    {
        return new self($an_id, $a_name, [], self::IS_NEW);
    }

    /**
     * @return UserId
     */
    public function id()
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
     * @return array
     */
    public function favoriteDrinks()
    {
        return $this->rated_drinks;
    }

    public function addDrink(DrinkId $a_drink_id)
    {
        $drink_was_rated = new DrinkWasRated($a_drink_id, $this->id);
        $this->record($drink_was_rated);
        $this->rated_drinks[] = $a_drink_id;
    }
}
