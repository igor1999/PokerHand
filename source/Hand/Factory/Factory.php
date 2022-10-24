<?php

namespace PokerHand\Hand\Factory;

use PokerHand\Collection\Exception\DuplicatedCardException;
use PokerHand\Collection\Exception\NotInScopeException;
use PokerHand\Hand\Exception\NotValidException;

use PokerHand\Hand\StraightFlush\StraightFlush;
use PokerHand\Hand\Four\Four;
use PokerHand\Hand\FullHouse\FullHouse;
use PokerHand\Hand\Flush\Flush;
use PokerHand\Hand\Straight\Straight;
use PokerHand\Hand\Set\Set;
use PokerHand\Hand\TwoPairs\TwoPairs;
use PokerHand\Hand\Pair\Pair;
use PokerHand\Hand\HighCard\HighCard;

use PokerHand\Card\CardInterface;
use PokerHand\Hand\StraightFlush\StraightFlushInterface;
use PokerHand\Hand\Four\FourInterface;
use PokerHand\Hand\FullHouse\FullHouseInterface;
use PokerHand\Hand\Flush\FlushInterface;
use PokerHand\Hand\Straight\StraightInterface;
use PokerHand\Hand\Set\SetInterface;
use PokerHand\Hand\TwoPairs\TwoPairsInterface;
use PokerHand\Hand\Pair\PairInterface;
use PokerHand\Hand\HighCard\HighCardInterface;

class Factory implements FactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private static FactoryInterface $instance;


    /**
     * @return FactoryInterface
     */
    public static function getInstance(): FactoryInterface
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param CardInterface $highCard
     * @return StraightFlushInterface
     * @throws NotValidException
     */
    public function createStraightFlush(CardInterface $highCard): StraightFlushInterface
    {
        return new StraightFlush($highCard);
    }

    /**
     * @param CardInterface $fourCard
     * @param CardInterface $kicker
     * @return FourInterface
     * @throws NotValidException
     */
    public function createFour(CardInterface $fourCard, CardInterface $kicker): FourInterface
    {
        return new Four($fourCard, $kicker);
    }

    /**
     * @param CardInterface $firstHighCard
     * @param CardInterface $secondHighCard
     * @param CardInterface $thirdHighCard
     * @param CardInterface $firstLowCard
     * @param CardInterface $secondLowCard
     * @return FullHouseInterface
     * @throws NotValidException
     * @throws DuplicatedCardException
     */
    public function createFullHouse(CardInterface $firstHighCard, CardInterface $secondHighCard,
                                    CardInterface $thirdHighCard, CardInterface $firstLowCard,
                                    CardInterface $secondLowCard): FullHouseInterface
    {
        return new FullHouse($firstHighCard, $secondHighCard, $thirdHighCard, $firstLowCard, $secondLowCard);
    }

    /**
     * @param CardInterface $card1
     * @param CardInterface $card2
     * @param CardInterface $card3
     * @param CardInterface $card4
     * @param CardInterface $card5
     * @return FlushInterface
     * @throws NotValidException
     * @throws DuplicatedCardException
     * @throws NotInScopeException
     */
    public function createFlush(CardInterface $card1, CardInterface $card2,
                                CardInterface $card3, CardInterface $card4,
                                CardInterface $card5): FlushInterface
    {
        return new Flush($card1, $card2, $card3, $card4, $card5);
    }

    /**
     * @param CardInterface $card1
     * @param CardInterface $card2
     * @param CardInterface $card3
     * @param CardInterface $card4
     * @param CardInterface $card5
     * @return StraightInterface
     * @throws NotValidException
     * @throws DuplicatedCardException
     * @throws NotInScopeException
     */
    public function createStraight(CardInterface $card1, CardInterface $card2,
                                CardInterface $card3, CardInterface $card4,
                                CardInterface $card5): StraightInterface
    {
        return new Straight($card1, $card2, $card3, $card4, $card5);
    }

    /**
     * @param CardInterface $firstSetCard
     * @param CardInterface $secondSetCard
     * @param CardInterface $thirdSetCard
     * @param CardInterface $firstKicker
     * @param CardInterface $secondKicker
     * @return SetInterface
     * @throws NotValidException
     * @throws DuplicatedCardException
     */
    public function createSet(CardInterface $firstSetCard, CardInterface $secondSetCard, CardInterface $thirdSetCard,
                              CardInterface $firstKicker, CardInterface $secondKicker): SetInterface
    {
        return new Set($firstSetCard, $secondSetCard, $thirdSetCard, $firstKicker, $secondKicker);
    }

    /**
     * @param CardInterface $firstPairCard1
     * @param CardInterface $firstPairCard2
     * @param CardInterface $secondPairCard1
     * @param CardInterface $secondPairCard2
     * @param CardInterface $kicker
     * @return TwoPairsInterface
     * @throws NotValidException
     * @throws DuplicatedCardException
     */
    public function createTwoPairs(CardInterface $firstPairCard1, CardInterface $firstPairCard2,
                                   CardInterface $secondPairCard1, CardInterface $secondPairCard2,
                                   CardInterface $kicker): TwoPairsInterface
    {
        return new TwoPairs($firstPairCard1, $firstPairCard2, $secondPairCard1, $secondPairCard2, $kicker);
    }

    /**
     * @param CardInterface $pairCard1
     * @param CardInterface $pairCard2
     * @param CardInterface $firstKicker
     * @param CardInterface $secondKicker
     * @param CardInterface $thirdKicker
     * @return PairInterface
     * @throws NotValidException
     * @throws DuplicatedCardException
     * @throws NotInScopeException
     */
    public function createPair(CardInterface $pairCard1, CardInterface $pairCard2,
                                   CardInterface $firstKicker, CardInterface $secondKicker,
                                   CardInterface $thirdKicker): PairInterface
    {
        return new Pair($pairCard1, $pairCard2, $firstKicker, $secondKicker, $thirdKicker);
    }

    /**
     * @param CardInterface $card1
     * @param CardInterface $card2
     * @param CardInterface $card3
     * @param CardInterface $card4
     * @param CardInterface $card5
     * @return HighCardInterface
     * @throws NotValidException
     * @throws DuplicatedCardException
     * @throws NotInScopeException
     */
    public function createHighCard(CardInterface $card1, CardInterface $card2,
                                   CardInterface $card3, CardInterface $card4,
                                   CardInterface $card5): HighCardInterface
    {
        return new HighCard($card1, $card2, $card3, $card4, $card5);
    }
}