<?php

namespace User\Application\Service;

use Core\Application\ApplicationService;
use \User\Application\Command\SayGreetings as SayGreetingsCommand;

final class SayGreetings implements ApplicationService
{
    public function __invoke(SayGreetingsCommand $command)
    {
        $user_name  = $command->name();
        $user_email = $command->email()->value();

        echo 'Hi ' . $user_name . ', your email is: ' . $user_email . '. We\'re glad to have you here. ' . PHP_EOL;
    }
}
