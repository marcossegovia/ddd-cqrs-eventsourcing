<?php

namespace User\Domain\Repository;

use User\Domain\Model\User;
use User\Domain\Model\UserId;

interface UserRepository
{
    public function add(User $user);

    public function getById(UserId $userId) : User;

    public function nextIdentity() : UserId;
}
