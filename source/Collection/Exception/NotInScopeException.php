<?php

namespace PokerHand\Collection\Exception;

class NotInScopeException extends \Exception
{
    const MESSAGE = 'Card with index \'%s\' not found in collection';


    /**
     * @param int $index
     */
    public function __construct(int $index)
    {
        $message = sprintf(static::MESSAGE, $index);

        parent::__construct($message);
    }
}