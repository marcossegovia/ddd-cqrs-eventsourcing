<?php

namespace User\Application\Service;

use Core\Application\Service\WithRecordedEvents;
use SimpleBus\Message\Message;
use User\Domain\Model\Email;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepository;

final class CreateNewUser extends WithRecordedEvents
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    public function handle(Message $message)
    {
        $user = User::create($this->user_repository->nextIdentity(), $message->name(), new Email($message->email()));
        $this->user_repository->add($user);
        $this->recordEvents($user);
    }
}
