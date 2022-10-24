<?php

namespace PokerHand\Hand\Base;

use PokerHand\Collection\Exception\DuplicatedCardException;

use PokerHand\Card\Range\RangeEnum;
use PokerHand\Card\Suit\SuitEnum;

use PokerHand\Card\Card;
use PokerHand\Collection\Collection;

use PokerHand\Card\CardInterface;
use PokerHand\Collection\CollectionInterface;

abstract class AbstractHand implements HandInterface
{
    /**
     * @param SuitEnum $suit
     * @param RangeEnum $range
     * @return Card
     */
    protected function createCard(SuitEnum $suit, RangeEnum $range): Card
    {
        return new Card($suit, $range);
    }

    /**
     * @param CardInterface[] $cards
     * @return Collection
     * @throws DuplicatedCardException
     */
    protected function createCollection(array $cards): Collection
    {
        return new Collection($cards);
    }

    /**
     * @param CardInterface $card1
     * @param CardInterface $card2
     * @param CardInterface $card3
     * @param CardInterface $card4
     * @param CardInterface $card5
     * @return Collection
     * @throws DuplicatedCardException
     */
    protected function createCollectionFrom5(CardInterface $card1, CardInterface $card2, CardInterface $card3,
                                             CardInterface $card4, CardInterface $card5): Collection
    {
        return $this->createCollection([$card1, $card2, $card3, $card4, $card5]);
    }

    /**
     * @param CollectionInterface $cards
     * @return bool
     */
    protected function isStraight(CollectionInterface $cards): bool
    {
        $straight = $cards->findStraight();

        return count($straight) == $cards->getLength();
    }

    /**
     * @param CollectionInterface $cards
     * @return bool
     */
    protected function isFlush(CollectionInterface $cards): bool
    {
        $f = function(CardInterface $card)
        {
            return $card->getSuit();
        };
        $suits = array_map($f, $cards->getCards());
        $suits = array_unique($suits, SORT_REGULAR);

        return count($suits) == 1;
    }

    /**
     * @param CollectionInterface $cards
     * @return bool
     */
    protected function isRangesUnique(CollectionInterface $cards): bool
    {
        $f = function(CardInterface $card)
        {
            return $card->getRange();
        };
        $ranges = array_map($f, $cards->getCards());
        $ranges = array_unique($ranges,SORT_REGULAR);

        return count($ranges) == $cards->getLength();
    }

    /**
     * @param HandInterface $hand
     * @return bool|null
     */
    protected function compareByRanking(HandInterface $hand): ?bool
    {
        return match (true) {
            $this->getRanking()->value > $hand->getRanking()->value => true,
            $this->getRanking()->value < $hand->getRanking()->value => false,
            default => null
        };
    }
}