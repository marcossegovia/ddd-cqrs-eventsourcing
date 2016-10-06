<?php

namespace User\Application\Service;

use SimpleBus\Message\Handler\MessageHandler;
use SimpleBus\Message\Message;

final class SayGreetings implements MessageHandler
{
    public function handle(Message $message)
    {
        $user_name = $message->name();
        $user_email = $message->email()->value();

        echo 'Hi ' . $user_name . ', your email is: ' . $user_email . '. We\'re glad to have you here. '. PHP_EOL;
    }
}
