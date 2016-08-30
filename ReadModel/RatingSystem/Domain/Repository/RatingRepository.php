<?php

namespace ReadModel\RatingSystem\Domain\Repository;

use ReadModel\RatingSystem\Domain\Model\Rating;
use Store\Domain\Model\DrinkId;
use User\Domain\Model\UserId;

interface RatingRepository
{
    public function getUsersByNumberOfDrinksRated() : Rating;
    
    public function getUsers() : array;
    
    public function getDrinks() : array;

    public function updateDrink(
        DrinkId $a_drink_id,
        string $a_drink_name
    );

    public function updateRating(
        UserId $a_user_id,
        DrinkId $a_drink_id
    );

    public function updateUser(
        UserId $a_user_id,
        string $a_user_name
    );
}
