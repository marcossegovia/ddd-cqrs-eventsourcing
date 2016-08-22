<?php

namespace ReadModel\RatingSystem\Application\Service;

use ReadModel\RatingSystem\Domain\Repository\RatingRepository;

final class GetUsers
{
    /** @var RatingRepository */
    private $rating_repository;

    public function __construct(RatingRepository $rating_repository)
    {
        $this->rating_repository = $rating_repository;
    }

    public function __invoke()
    {
        return $this->rating_repository->getUsers();
    }
}
