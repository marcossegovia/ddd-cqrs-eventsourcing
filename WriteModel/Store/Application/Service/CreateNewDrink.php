<?php

namespace Store\Application\Service;

use Core\Application\Service\ApplicationService;
use Store\Application\Command\CreateNewDrink as CreateNewDrinkCommand;
use Store\Domain\Model\Drink;
use Store\Domain\Repository\DrinkRepository;

final class CreateNewDrink implements ApplicationService
{
    /** @var DrinkRepository */
    private $drink_repository;

    public function __construct(DrinkRepository $a_drink_repository)
    {
        $this->drink_repository = $a_drink_repository;
    }

    public function __invoke(CreateNewDrinkCommand $command)
    {
        $drink = Drink::create($this->drink_repository->nextIdentity(), $command->name());
        $this->drink_repository->add($drink);
    }
}
