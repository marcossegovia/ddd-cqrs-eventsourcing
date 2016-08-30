<?php

namespace ReadModel\RatingSystem\Infrastructure\Repository\InMemory\Rating;

use ReadModel\RatingSystem\Domain\Model\Rating;
use ReadModel\RatingSystem\Domain\Repository\RatingRepository as RatingRepositoryInterface;
use Store\Domain\Model\DrinkId;
use User\Domain\Model\UserId;

class RatingRepository implements RatingRepositoryInterface
{
    /** @var array */
    private $drinks = [];

    /** @var array */
    private $users = [];

    /** @var array */
    private $users_drinks = [];

    public function getUsersByNumberOfDrinksRated() : Rating
    {
        $users_with_drinks = [];
        foreach ($this->users as $user)
        {
            if (isset($this->users_drinks[$user['id']]))
            {
                $user_to_insert      = [
                    'id'           => $user['id'],
                    'name'         => $user['name'],
                    'rated_drinks' => $this->users_drinks[$user['id']]['rated_drinks']
                ];
                $users_with_drinks[] = $user_to_insert;
            }
        }
        $rating = new Rating($users_with_drinks);

        return $rating;
    }

    public function getUsers() : array
    {
        return $this->users;
    }

    public function getDrinks() : array
    {
        return $this->drinks;
    }

    public function updateDrink(
        DrinkId $a_drink_id,
        string $a_drink_name
    )
    {
        $drink_data = [
            'id'   => $a_drink_id->__toString(),
            'name' => $a_drink_name
        ];

        $this->drinks[$a_drink_id->__toString()] = $drink_data;
    }

    public function updateRating(
        UserId $a_user_id,
        DrinkId $a_drink_id
    )
    {
        $rated_drinks    = isset($this->users_drinks[$a_user_id->__toString()]['rated_drinks']) ?
            $this->users_drinks[$a_user_id->__toString()]['rated_drinks'] : [];
        $rated_drinks[]  = $a_drink_id;
        $user_drink_data = [
            'id'           => $a_user_id->__toString(),
            'rated_drinks' => $rated_drinks
        ];

        $this->users_drinks[$a_user_id->__toString()] = $user_drink_data;
    }

    public function updateUser(
        UserId $a_user_id,
        string $a_user_name
    )
    {
        $user_data = [
            'id'   => $a_user_id->__toString(),
            'name' => $a_user_name
        ];

        $this->users[$a_user_id->__toString()] = $user_data;
    }
}
