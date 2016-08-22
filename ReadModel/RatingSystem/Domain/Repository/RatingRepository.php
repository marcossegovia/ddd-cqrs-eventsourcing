<?php

namespace ReadModel\RatingSystem\Domain\Repository;

use ReadModel\RatingSystem\Domain\Model\Rating;

interface RatingRepository
{
    public function getUsersByNumberOfDrinksRated() : Rating;
    
    public function getUsers() : array;
    
    public function getDrinks() : array;

    public function updateDrink(
        string $a_drink_id,
        string $a_drink_name
    );

    public function updateRating(
        string $a_user_id,
        string $a_drink_id
    );

    public function updateUser(
        string $a_user_id,
        string $a_user_name
    );
}
