<?php

namespace User\Domain\Model;

use Core\Domain\Exception\InvalidValueObjectArgumentException;

final class Email
{
    private $value;

    public function __construct($value)
    {
        $filteredValue = filter_var($value, FILTER_VALIDATE_EMAIL);
        if ($filteredValue === false)
        {
            throw new InvalidValueObjectArgumentException($value, array('string (valid email address)'));
        }
        $this->value = $filteredValue;
    }

    public function getLocalPart()
    {
        $parts = explode('@', $this->value);

        return $parts[0];
    }

    public function getDomainPart()
    {
        $parts  = \explode('@', $this->value);
        $domain = \trim($parts[1], '[]');

        return $domain;
    }

    public function value()
    {
        return $this->value;
    }
}
