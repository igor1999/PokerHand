<?php

namespace PokerHand\Hand\Exception;

class NotValidException extends \Exception
{
    const MESSAGE = 'Cards are not valid for Hand \'%s\'';


    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $message = sprintf(static::MESSAGE, $name);

        parent::__construct($message);
    }
}