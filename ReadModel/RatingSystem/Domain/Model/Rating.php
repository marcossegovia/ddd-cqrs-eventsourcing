<?php

namespace ReadModel\RatingSystem\Domain\Model;

class Rating
{
    /** @var array */
    private $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    /**
     * @return array
     */
    public function users()
    {
        return $this->users;
    }

}
