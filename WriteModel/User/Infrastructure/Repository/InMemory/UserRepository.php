<?php

namespace User\Infrastructure\Repository\InMemory;

use MarcosSegovia\User\Domain\Model\User;
use MarcosSegovia\User\Domain\Model\UserId;
use Ramsey\Uuid\Uuid;
use User\Domain\Repository\UserRepository as UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private $users = [];

    public function add(User $user)
    {
        $this->users[(string)$user->id()] = $user;
    }

    public function getById(UserId $userId) : User
    {
        if (!isset($this->users[(string)$userId]))
        {
            throw new \LogicException(sprintf('User "%s" not found', $userId));
        }

        return $this->users[(string)$userId];
    }

    public function nextIdentity() : UserId
    {
        return UserId::fromString((string)Uuid::uuid4());
    }
}
