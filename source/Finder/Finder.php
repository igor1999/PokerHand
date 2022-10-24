<?php

namespace PokerHand\Finder;

use PokerHand\Collection\Exception\DuplicatedCardException;
use PokerHand\Collection\Exception\NotInScopeException;
use PokerHand\Finder\Exception\NotFoundException;
use PokerHand\Finder\Exception\TooLessException;
use PokerHand\Hand\Exception\NotValidException;

use PokerHand\Card\Range\RangeEnum;
use PokerHand\Card\Suit\SuitEnum;

use PokerHand\Collection\Collection;

use PokerHand\Hand\Factory\FactoryAwareTrait as HandFactoryAwareTrait;

use PokerHand\Card\CardInterface;
use PokerHand\Collection\CollectionInterface;
use PokerHand\Hand\Base\HandInterface;
use PokerHand\Hand\StraightFlush\StraightFlushInterface;
use PokerHand\Hand\Four\FourInterface;
use PokerHand\Hand\FullHouse\FullHouseInterface;
use PokerHand\Hand\Flush\FlushInterface;
use PokerHand\Hand\Straight\StraightInterface;
use PokerHand\Hand\Set\SetInterface;
use PokerHand\Hand\TwoPairs\TwoPairsInterface;
use PokerHand\Hand\Pair\PairInterface;
use PokerHand\Hand\HighCard\HighCardInterface;

class Finder implements FinderInterface
{
    use HandFactoryAwareTrait;

    /**
     * @var CollectionInterface[]
     */
    private readonly array $suits;

    /**
     * @var CollectionInterface[]
     */
    private readonly array $ranges;


    /**
     * @param CollectionInterface $cards
     * @throws DuplicatedCardException
     * @throws TooLessException
     */
    public function __construct(CollectionInterface $cards)
    {
        if ($cards->getLength() < 5) {
            throw new TooLessException($cards);
        }

        $suits = [];
        foreach (SuitEnum::cases() as $suit) {
            $suitCards = $cards->findBySuit($suit);

            if (!empty($suitCards)) {
                $suits[$suit->name] = $this->createCollection($suitCards)->order();
            }
        }
        $this->suits = $suits;

        $ranges = [];
        foreach (RangeEnum::cases() as $range) {
            $rangeCards = $cards->findByRange($range);

            if (!empty($rangeCards)) {
                $ranges[$range->value] = $this->createCollection($rangeCards);
            }
        }
        $this->ranges = $ranges;
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
     * @return CollectionInterface[]
     */
    protected function getSuits(): array
    {
        return $this->suits;
    }

    /**
     * @return CollectionInterface[]
     */
    protected function getRanges(): array
    {
        return $this->ranges;
    }

    /**
     * @return HandInterface
     * @throws DuplicatedCardException
     * @throws NotInScopeException
     * @throws NotValidException
     */
    public function find(): HandInterface
    {
        try {
            $hand = $this->findStraightFlush();
        } catch (NotFoundException) {
            try {
                $hand = $this->findFour();
            } catch (NotFoundException) {
                try {
                    $hand = $this->findFullHouse();
                } catch (NotFoundException) {
                    try {
                        $hand = $this->findFlush();
                    } catch (NotFoundException) {
                        try {
                            $hand = $this->findStraight();
                        } catch (NotFoundException) {
                            try {
                                $hand = $this->findSet();
                            } catch (NotFoundException) {
                                try {
                                    $hand = $this->findTwoPairs();
                                } catch (NotFoundException) {
                                    try {
                                        $hand = $this->findPair();
                                    } catch (NotFoundException) {
                                        $hand = $this->findHighCard();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $hand;
    }

    /**
     * @return StraightFlushInterface
     * @throws DuplicatedCardException
     * @throws NotFoundException
     * @throws NotValidException
     * @throws NotInScopeException
     */
    protected function findStraightFlush(): StraightFlushInterface
    {
        $f = function(CollectionInterface $suitCollection)
        {
            return $suitCollection->findStraight();
        };
        $straights = array_map($f, $this->getSuits());

        $straights = array_filter($straights);

        if (empty($straights)) {
            throw new NotFoundException('Straight Flush');
        }

        $f = function(array $cards)
        {
            return array_pop($cards);
        };
        $highCards = array_map($f, $straights);
        $highCards = $this->createCollection($highCards)->order();

        return $this->getHandFactory()->createStraightFlush($highCards->getLast());
    }

    /**
     * @return FourInterface
     * @throws NotFoundException
     * @throws NotInScopeException
     * @throws NotValidException
     */
    protected function findFour(): FourInterface
    {
        $f = function(CollectionInterface $collection)
        {
            return $collection->getLength() == 4;
        };
        $fours = array_filter($this->getRanges(), $f);

        if (empty($fours)) {
            throw new NotFoundException('Four');
        }

        /** @var CollectionInterface $four */
        $four = array_pop($fours);

        $range = $four->getFirst()->getRange();

        $f = function(CollectionInterface $collection) use ($range)
        {
            return $collection->getFirst()->getRange() != $range;
        };
        $kickers = array_filter($this->getRanges(), $f);
        $kicker = array_pop($kickers);

        return $this->getHandFactory()->createFour($four->getFirst(), $kicker->getFirst());
    }

    /**
     * @return FullHouseInterface
     * @throws DuplicatedCardException
     * @throws NotFoundException
     * @throws NotInScopeException
     * @throws NotValidException
     */
    protected function findFullHouse(): FullHouseInterface
    {
        $f = function(CollectionInterface $collection)
        {
            return $collection->getLength() == 3;
        };
        $fullHouses = array_filter($this->getRanges(), $f);

        if (empty($fullHouses)) {
            throw new NotFoundException('Full House');
        }

        /** @var CollectionInterface $fullHouse */
        $fullHouse = array_pop($fullHouses);

        $range = $fullHouse->getFirst()->getRange();

        $f = function(CollectionInterface $collection) use ($range)
        {
            return ($collection->getFirst()->getRange() != $range) && ($collection->getLength() >= 2);
        };
        $kickers = array_filter($this->getRanges(), $f);

        if (empty($kickers)) {
            throw new NotFoundException('Full House');
        }

        $kicker = array_pop($kickers);

        return $this->getHandFactory()->createFullHouse(
            $fullHouse->get(0), $fullHouse->get(1), $fullHouse->get(2), $kicker->get(0), $kicker->get(1));
    }

    /**
     * @return FlushInterface
     * @throws DuplicatedCardException
     * @throws NotFoundException
     * @throws NotInScopeException
     * @throws NotValidException
     */
    protected function findFlush(): FlushInterface
    {
        $f = function(CollectionInterface $collection)
        {
            return $collection->getLength() >= 5;
        };
        $flushes = array_filter($this->getSuits(), $f);

        if (empty($flushes)) {
            throw new NotFoundException('Flush');
        }

        $f = function(CollectionInterface $collection1, CollectionInterface $collection2)
        {
            return match ($collection2->compare($collection1)) {
                true => 1,
                false => -1,
                default => 0,
            };
        };
        usort($flushes, $f);

        $flush = array_pop($flushes);
        $flush = array_slice($flush->getCards(), -5);

        return $this->getHandFactory()->createFlush($flush[0], $flush[1], $flush[2], $flush[3], $flush[4]);
    }

    /**
     * @return StraightInterface
     * @throws DuplicatedCardException
     * @throws NotFoundException
     * @throws NotInScopeException
     * @throws NotValidException
     */
    protected function findStraight(): StraightInterface
    {
        $f = function(CollectionInterface $collection)
        {
            return $collection->getFirst();
        };
        $cards = array_map($f, $this->getRanges());
        $straight = $this->createCollection($cards);

        $straight = $straight->findStraight();

        if (empty($straight)) {
            throw new NotFoundException('Straight');
        }

        return $this->getHandFactory()->createStraight(
            $straight[0], $straight[1], $straight[2], $straight[3], $straight[4]);
    }

    /**
     * @return SetInterface
     * @throws DuplicatedCardException
     * @throws NotFoundException
     * @throws NotInScopeException
     * @throws NotValidException
     */
    protected function findSet(): SetInterface
    {
        $f = function(CollectionInterface $collection)
        {
            return $collection->getLength() == 3;
        };
        $sets = array_filter($this->getRanges(), $f);

        if (empty($sets)) {
            throw new NotFoundException('Set');
        }

        /** @var CollectionInterface $set */
        $set = array_pop($sets);

        $range = $set->getFirst()->getRange();

        $f = function(CollectionInterface $collection) use ($range)
        {
            return $collection->getFirst()->getRange() != $range;
        };
        $kickers = array_filter($this->getRanges(), $f);
        $kicker1 = array_pop($kickers);
        $kicker2 = array_pop($kickers);

        return $this->getHandFactory()->createSet(
            $set->get(0), $set->get(1), $set->get(2), $kicker1->get(0), $kicker2->get(0));
    }

    /**
     * @return TwoPairsInterface
     * @throws DuplicatedCardException
     * @throws NotFoundException
     * @throws NotInScopeException
     * @throws NotValidException
     */
    protected function findTwoPairs(): TwoPairsInterface
    {
        $f = function(CollectionInterface $collection)
        {
            return $collection->getLength() == 2;
        };
        $pairs = array_filter($this->getRanges(), $f);

        if (count($pairs) < 2) {
            throw new NotFoundException('Two Pairs');
        }

        $pair1 = array_pop($pairs);
        $pair2 = array_pop($pairs);

        $range1 = $pair1->getFirst()->getRange();
        $range2 = $pair2->getFirst()->getRange();

        $f = function(CollectionInterface $collection) use ($range1, $range2)
        {
            return !in_array($collection->getFirst()->getRange(), [$range1, $range2]);
        };
        $kickers = array_filter($this->getRanges(), $f);
        $kicker = array_pop($kickers);

        return $this->getHandFactory()->createTwoPairs(
            $pair1->get(0), $pair1->get(1), $pair2->get(0), $pair2->get(1), $kicker->get(0));
    }

    /**
     * @return PairInterface
     * @throws DuplicatedCardException
     * @throws NotFoundException
     * @throws NotInScopeException
     * @throws NotValidException
     */
    protected function findPair(): PairInterface
    {
        $f = function(CollectionInterface $collection)
        {
            return $collection->getLength() == 2;
        };
        $pairs = array_filter($this->getRanges(), $f);

        if (empty($pairs)) {
            throw new NotFoundException('Pair');
        }

        /** @var CollectionInterface $pair */
        $pair = array_pop($pairs);

        $range = $pair->getFirst()->getRange();

        $f = function(CollectionInterface $collection) use ($range)
        {
            return $collection->getFirst()->getRange() != $range;
        };
        $kickers = array_filter($this->getRanges(), $f);
        $kicker1 = array_pop($kickers);
        $kicker2 = array_pop($kickers);
        $kicker3 = array_pop($kickers);

        return $this->getHandFactory()->createPair(
            $pair->get(0), $pair->get(1), $kicker1->get(0), $kicker2->get(0), $kicker3->get(0));
    }

    /**
     * @return HighCardInterface
     * @throws DuplicatedCardException
     * @throws NotInScopeException
     * @throws NotValidException
     */
    protected function findHighCard(): HighCardInterface
    {
        $f = function(CollectionInterface $collection)
        {
            return $collection->getFirst();
        };
        $cards = array_map($f, $this->getRanges());

        $cards = array_slice($cards, -5);

        return $this->getHandFactory()->createHighCard($cards[0], $cards[1], $cards[2], $cards[3], $cards[4]);
    }
}