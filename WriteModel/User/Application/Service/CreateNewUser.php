<?php

namespace User\Application\Service;

use Core\Application\ApplicationService;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepository;
use User\Application\Command\CreateNewUser as CreateNewUserCommand;

final class CreateNewUser implements ApplicationService
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    public function __invoke(CreateNewUserCommand $command)
    {
        $user = User::create($this->user_repository->nextIdentity(), $command->name(), $command->email());
        $this->user_repository->add($user);
    }
}
