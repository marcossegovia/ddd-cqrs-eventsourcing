<?php

namespace ReadModel\RatingSystem\Application\Subscriber;

use Core\Application\Subscriber\ApplicationSubscriber;
use Core\Domain\Model\DomainEvent;
use ReadModel\RatingSystem\Domain\Repository\RatingRepository;
use Store\Domain\Model\DrinkWasCreated;
use Store\Domain\Model\DrinkWasRated;

final class DrinkProjector implements ApplicationSubscriber
{
    /** @var RatingRepository */
    private $rating_repository;

    public function __construct(RatingRepository $a_rating_repository)
    {
        $this->rating_repository = $a_rating_repository;
    }

    public function __invoke(DomainEvent $event)
    {
        if ($event instanceof DrinkWasRated)
        {
            $this->rating_repository->updateRating($event->aggregateId(), $event->drinkId());
        }
        if ($event instanceof DrinkWasCreated)
        {
            $this->rating_repository->updateDrink($event->aggregateId(), $event->name());
        }
    }
}
