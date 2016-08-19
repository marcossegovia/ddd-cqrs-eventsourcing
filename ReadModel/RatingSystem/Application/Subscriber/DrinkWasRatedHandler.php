<?php

namespace ReadModel\RatingSystem\Application\Subscriber;

use ReadModel\RatingSystem\Domain\Repository\RatingRepository;
use Store\Domain\Model\DrinkWasRated;

class DrinkWasRatedHandler
{
    /** @var RatingRepository */
    private $rating_repository;

    public function __construct(RatingRepository $a_rating_repository)
    {
        $this->rating_repository = $a_rating_repository;
    }

    public function __invoke(DrinkWasRated $event)
    {
        $this->rating_repository->updateRating($event->userId(), $event->drinkId());
    }
}
