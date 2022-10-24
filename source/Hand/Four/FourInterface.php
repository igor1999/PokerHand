<?php

namespace PokerHand\Hand\Four;

use PokerHand\Card\CardInterface;
use PokerHand\Hand\Base\HandInterface;

interface FourInterface extends HandInterface
{
    /**
     * @return CardInterface
     */
    public function getFourCard(): CardInterface;

    /**
     * @return CardInterface[]
     */
    public function getFourCards(): array;

    /**
     * @return CardInterface
     */
    public function getKicker(): CardInterface;
}