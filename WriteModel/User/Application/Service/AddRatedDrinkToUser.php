<?php

namespace User\Application\Service;

use Core\Application\Service\ApplicationService;
use Store\Domain\Model\DrinkId;
use User\Domain\Model\UserId;
use User\Domain\Repository\UserRepository;
use User\Application\Command\AddRatedDrinkToUser as AddRatedDrinkToUserCommand;

final class AddRatedDrinkToUser implements ApplicationService
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    public function __invoke(AddRatedDrinkToUserCommand $command)
    {
        $user = $this->user_repository->getById(UserId::fromString($command->userId()));
        $user->addDrink(DrinkId::fromString($command->drinkId()));
        $this->user_repository->add($user);
    }
}
