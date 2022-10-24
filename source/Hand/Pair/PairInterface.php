<?php

namespace PokerHand\Hand\Pair;

use PokerHand\Card\CardInterface;
use PokerHand\Hand\Base\HandInterface;

interface PairInterface extends HandInterface
{
    /**
     * @return CardInterface
     */
    public function getPairCard1(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getPairCard2(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getFirstKicker(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getSecondKicker(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getThirdKicker(): CardInterface;
}