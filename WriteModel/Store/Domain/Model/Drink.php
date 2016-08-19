<?php

namespace Store\Domain\Model;

use SimpleBus\Message\Recorder\ContainsRecordedMessages;
use SimpleBus\Message\Recorder\PrivateMessageRecorderCapabilities;

class Drink implements ContainsRecordedMessages
{
    const IS_NEW = 'is_new';

    use PrivateMessageRecorderCapabilities;

    /** @var DrinkId */
    private $id;

    /** @var string */
    private $name;

    protected function __construct(
        DrinkId $an_id,
        string $a_name,
        string $is_new
    )
    {
        $this->id   = $an_id;
        $this->name = $a_name;
        if (self::IS_NEW === $is_new)
        {
            $this->record(new DrinkWasCreated($an_id, $a_name));
        }
    }

    public static function create(
        DrinkId $an_id,
        string $a_name
    )
    {
        return new self($an_id, $a_name, self::IS_NEW);
    }

    /**
     * @return DrinkId
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

}
