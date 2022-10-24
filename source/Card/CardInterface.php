<?php

namespace PokerHand\Card;

use PokerHand\Card\Range\RangeEnum;
use PokerHand\Card\Suit\SuitEnum;

interface CardInterface
{
    /**
     * @return SuitEnum
     */
    public function getSuit(): SuitEnum;

    /**
     * @return RangeEnum
     */
    public function getRange(): RangeEnum;

    /**
     * @param CardInterface $card
     * @return bool|null
     */
    public function isHigher(CardInterface $card): ?bool;

    /**
     * @param CardInterface $card
     * @return bool
     */
    public function IsEqual(CardInterface $card): bool;

    /**
     * @param CardInterface $card
     * @param bool $aceAsOne
     * @return bool
     */
    public function IsNext(CardInterface $card, bool $aceAsOne = false): bool;

    /**
     * @param CardInterface $card
     * @return bool
     */
    public function isIdentical(CardInterface $card): bool;
}