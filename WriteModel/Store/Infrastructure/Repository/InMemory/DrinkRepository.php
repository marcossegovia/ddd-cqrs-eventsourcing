<?php

namespace Store\Infrastructure\Repository\InMemory;

use Ramsey\Uuid\Uuid;
use Store\Domain\Model\Drink;
use Store\Domain\Model\DrinkId;
use Store\Domain\Repository\DrinkRepository as DrinkRepositoryInterface;

class DrinkRepository implements DrinkRepositoryInterface
{
    private $drinks = [];
    
    public function add(Drink $drink)
    {
        $this->drinks[(string)$drink->id()] = $drink;
    }

    public function getById(DrinkId $drink_id) : Drink
    {
        if (!isset($this->drinks[(string)$drink_id]))
        {
            throw new \LogicException(sprintf('Drink "%s" not found', $drink_id));
        }

        return $this->drinks[(string)$drink_id];
    }

    public function nextIdentity() : DrinkId
    {
        return DrinkId::fromString((string)Uuid::uuid4());
    }
}
