<?php

namespace PokerHand\Card;

use PokerHand\Card\Range\RangeEnum;
use PokerHand\Card\Suit\SuitEnum;

class Card implements CardInterface
{
    /**
     * @var SuitEnum
     */
    private readonly SuitEnum $suit;

    /**
     * @var RangeEnum
     */
    private readonly RangeEnum $range;


    /**
     * @param SuitEnum $suit
     * @param RangeEnum $range
     */
    public function __construct(SuitEnum $suit, RangeEnum $range)
    {
        $this->suit = $suit;
        $this->range = $range;
    }

    /**
     * @return SuitEnum
     */
    public function getSuit(): SuitEnum
    {
        return $this->suit;
    }

    /**
     * @return RangeEnum
     */
    public function getRange(): RangeEnum
    {
        return $this->range;
    }

    /**
     * @param CardInterface $card
     * @return bool|null
     */
    public function isHigher(CardInterface $card): ?bool
    {
        return $this->getRange()->IsHigher($card->getRange());
    }

    /**
     * @param CardInterface $card
     * @return bool
     */
    public function IsEqual(CardInterface $card): bool
    {
        return $this->getRange() == $card->getRange();
    }

    /**
     * @param CardInterface $card
     * @param bool $aceAsOne
     * @return bool
     */
    public function IsNext(CardInterface $card, bool $aceAsOne = false): bool
    {
        return $this->getRange()->IsNext($card->getRange(), $aceAsOne);
    }

    /**
     * @param CardInterface $card
     * @return bool
     */
    public function isIdentical(CardInterface $card): bool
    {
        return ($this->getSuit() == $card->getSuit()) && $this->IsEqual($card);
    }
}