<?php

namespace ReadModel\RatingSystem\Domain\Repository;

interface RatingRepository
{
    public function getUsersByNumberOfDrinks();

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
