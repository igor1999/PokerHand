<?php

namespace PokerHand\Hand\Set;

use PokerHand\Card\CardInterface;
use PokerHand\Hand\Base\HandInterface;

interface SetInterface extends HandInterface
{
    /**
     * @return CardInterface
     */
    public function getFirstSetCard(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getSecondSetCard(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getThirdSetCard(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getHighKicker(): CardInterface;

    /**
     * @return CardInterface
     */
    public function getLowKicker(): CardInterface;
}