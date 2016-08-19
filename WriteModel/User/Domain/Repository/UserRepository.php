<?php

namespace User\Domain\Repository;

use MarcosSegovia\User\Domain\Model\User;
use MarcosSegovia\User\Domain\Model\UserId;

interface UserRepository
{
    public function add(User $user);

    public function getById(UserId $userId) : User;

    public function nextIdentity() : UserId;
}
