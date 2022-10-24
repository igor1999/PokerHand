<?php

namespace PokerHand\Finder\Exception;

class NotFoundException extends \Exception
{
    const MESSAGE = 'Hand \'%s\' not found';


    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $message = sprintf(static::MESSAGE, $name);

        parent::__construct($message);
    }
}