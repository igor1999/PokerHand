<?php

namespace PokerHand\Hand\TwoPairs;

use PokerHand\Card\CardInterface;
use PokerHand\Hand\Base\HandInterface;

interface TwoPairsInterface extends HandInterface
{
    /**
     * @return CardInterface
     */
    public function getHighPairCard1(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getHighPairCard2(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getLowPairCard1(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getLowPairCard2(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getKicker(): CardInterface;
}