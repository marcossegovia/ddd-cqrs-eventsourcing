<?php

namespace ReadModel\RatingSystem\Application\Subscriber;

use ReadModel\RatingSystem\Domain\Repository\RatingRepository;
use User\Domain\Model\UserWasCreated;

class UserWasCreatedHandler
{
    /** @var RatingRepository */
    private $rating_repository;

    public function __construct(RatingRepository $a_rating_repository)
    {
        $this->rating_repository = $a_rating_repository;
    }

    public function __invoke(UserWasCreated $event)
    {
        $this->rating_repository->updateUser($event->id(), $event->name());
    }
}
