<?php

namespace PokerHand\Finder\Exception;

use PokerHand\Collection\CollectionInterface;

class TooLessException extends \Exception
{
    const MESSAGE = 'It should be at least five cards in hand, \'%s\' given';


    /**
     * @param CollectionInterface $cards
     */
    public function __construct(CollectionInterface $cards)
    {
        $message = sprintf(static::MESSAGE, $cards->getLength());

        parent::__construct($message);
    }
}