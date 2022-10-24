<?php

namespace PokerHand\Collection\Exception;

use PokerHand\Card\CardInterface;

class DuplicatedCardException extends \Exception
{
    const MESSAGE = 'Card \'%1$s %2$s\' already exists in collection';


    /**
     * @param CardInterface $card
     */
    public function __construct(CardInterface $card)
    {
        $message = sprintf(static::MESSAGE, $card->getRange()->value, $card->getSuit()->name);

        parent::__construct($message);
    }
}