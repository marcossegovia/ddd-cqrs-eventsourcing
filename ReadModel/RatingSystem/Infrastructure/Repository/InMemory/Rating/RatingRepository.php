<?php

namespace ReadModel\RatingSystem\Infrastructure\Repository\InMemory\Rating;

use ReadModel\RatingSystem\Domain\Model\Rating;
use ReadModel\RatingSystem\Domain\Repository\RatingRepository as RatingRepositoryInterface;

class RatingRepository implements RatingRepositoryInterface
{
    private $drinks       = [];
    private $users        = [];
    private $users_drinks = [];

    public function getUsersByNumberOfDrinks()
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
        $ratings = new Rating($this->users);

        return $ratings;
    }

    public function updateDrink(
        string $a_drink_id,
        string $a_drink_name
    )
    {
        $drink_data = [
            'id'   => $a_drink_id,
            'name' => $a_drink_name
        ];

        $this->drinks[$a_drink_id] = $drink_data;
    }

    public function updateRating(
        string $a_user_id,
        string $a_drink_id
    )
    {
        $rated_drinks    = isset($this->users_drinks[$a_user_id]['rated_drinks']) ?
            $this->users_drinks[$a_user_id]['rated_drinks'] : [];
        $rated_drinks[]  = $a_drink_id;
        $user_drink_data = [
            'id'           => $a_user_id,
            'rated_drinks' => $rated_drinks
        ];

        $this->users_drinks[$a_user_id] = $user_drink_data;
    }

    public function updateUser(
        string $a_user_id,
        string $a_user_name
    )
    {
        $user_data = [
            'id'   => $a_user_id,
            'name' => $a_user_name
        ];

        $this->users[$a_user_id] = $user_data;
    }
}
