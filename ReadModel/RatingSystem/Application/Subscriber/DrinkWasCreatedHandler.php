<?php

namespace ReadModel\RatingSystem\Application\Subscriber;

use ReadModel\RatingSystem\Domain\Repository\RatingRepository;
use Store\Domain\Model\DrinkWasCreated;

class DrinkWasCreatedHandler
{
    /** @var RatingRepository */
    private $rating_repository;

    public function __construct(RatingRepository $a_rating_repository)
    {
        $this->rating_repository = $a_rating_repository;
    }

    public function __invoke(DrinkWasCreated $event)
    {
        $this->rating_repository->updateDrink($event->id(), $event->name());
    }
}
