<?php

namespace Core\Domain\Model;

use SimpleBus\Message\Message;

trait MessageRecorderCapabilities
{
    private $messages = array();

    /**
     * {@inheritdoc}
     */
    public function recordedMessages()
    {
        return $this->messages;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseMessages()
    {
        $this->messages = [];
    }

    /**
     * Record a message.
     *
     * @param Message $message
     */
    public function record(Message $message)
    {
        $this->messages[] = $message;
    }
}
