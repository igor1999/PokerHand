<?php

namespace PokerHand\Hand\Base\Part\CommonCards;

use PokerHand\Card\CardInterface;

interface CommonCardsInterface
{
    /**
     * @return CardInterface
     */
    public function getHighCard(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getSecondCard(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getThirdCard(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getFourthCard(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getFifthCard(): CardInterface;
}