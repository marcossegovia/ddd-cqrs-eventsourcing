<?php

namespace User\Application\Service;

use Core\Application\ApplicationService;
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
        $user = $this->user_repository->getById($command->userId());
        $user->addDrink($command->drinkId());
        $this->user_repository->add($user);
    }
}
