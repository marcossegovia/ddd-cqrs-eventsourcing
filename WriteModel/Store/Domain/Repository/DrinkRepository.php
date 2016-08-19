<?php

namespace Store\Domain\Repository;

use Store\Domain\Model\Drink;
use Store\Domain\Model\DrinkId;

interface DrinkRepository
{
    public function add(Drink $drink);

    public function getById(DrinkId $drink_id) : Drink;

    public function nextIdentity() : DrinkId;
}
