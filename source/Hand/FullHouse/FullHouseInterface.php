<?php

namespace PokerHand\Hand\FullHouse;

use PokerHand\Card\CardInterface;
use PokerHand\Hand\Base\HandInterface;

interface FullHouseInterface extends HandInterface
{
    /**
     * @return CardInterface
     */
    public function getFirstHighCard(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getSecondHighCard(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getThirdHighCard(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getFirstLowCard(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getSecondLowCard(): CardInterface;
}