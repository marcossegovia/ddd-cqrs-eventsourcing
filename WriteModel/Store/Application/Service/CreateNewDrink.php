<?php

namespace Store\Application\Service;

use Core\Application\Service\WithRecordedEvents;
use SimpleBus\Message\Message;
use Store\Domain\Model\Drink;
use Store\Domain\Repository\DrinkRepository;

final class CreateNewDrink extends WithRecordedEvents
{
    /** @var DrinkRepository */
    private $drink_repository;

    public function __construct(DrinkRepository $a_drink_repository)
    {
        $this->drink_repository = $a_drink_repository;
    }

    /**
     * Handles the given message.
     *
     * @param Message $message
     *
     * @return void
     */
    public function handle(Message $message)
    {
        $drink = Drink::create($this->drink_repository->nextIdentity(), $message->name());
        $this->drink_repository->add($drink);
        $this->recordEvents($drink);
    }
}
