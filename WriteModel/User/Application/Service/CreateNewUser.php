<?php

namespace User\Application\Service;

use Core\Application\Service\WithRecordedEvents;
use MarcosSegovia\User\Domain\Model\User;
use SimpleBus\Message\Message;
use User\Domain\Repository\UserRepository;

final class CreateNewUser extends WithRecordedEvents
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    /**
     * Handles the given message.
     *
     * @param Message $message
     *
     * @return void
     */
    public function handle(Message $message)
    {
        $user = User::create($this->user_repository->nextIdentity(), $message->name());
        $this->user_repository->add($user);
        $this->recordEvents($user);
    }
}
