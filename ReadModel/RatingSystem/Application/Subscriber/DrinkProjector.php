<?php

namespace ReadModel\RatingSystem\Application\Subscriber;

use ReadModel\RatingSystem\Domain\Repository\RatingRepository;
use SimpleBus\Message\Message;
use SimpleBus\Message\Subscriber\MessageSubscriber;
use Store\Domain\Model\DrinkWasCreated;
use Store\Domain\Model\DrinkWasRated;

final class DrinkProjector implements MessageSubscriber
{
    /** @var RatingRepository */
    private $rating_repository;

    public function __construct(RatingRepository $a_rating_repository)
    {
        $this->rating_repository = $a_rating_repository;
    }

    /**
     * Provide the given message as a notification to this subscriber
     *
     * @param Message $message
     *
     * @return void
     */
    public function notify(Message $message)
    {
        if ($message instanceof DrinkWasRated)
        {
            $this->rating_repository->updateRating($message->aggregateId(), $message->drinkId());
        }
        if ($message instanceof DrinkWasCreated)
        {
            $this->rating_repository->updateDrink($message->aggregateId(), $message->name());
        }
    }
}
