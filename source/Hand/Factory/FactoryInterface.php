<?php

namespace PokerHand\Hand\Factory;

use PokerHand\Collection\Exception\DuplicatedCardException;
use PokerHand\Collection\Exception\NotInScopeException;
use PokerHand\Hand\Exception\NotValidException;

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

interface FactoryInterface
{
    /**
     * @return FactoryInterface
     */
    public static function getInstance(): FactoryInterface;

    /**
     * @param CardInterface $highCard
     * @return StraightFlushInterface
     * @throws NotValidException
     */
    public function createStraightFlush(CardInterface $highCard): StraightFlushInterface;

    /**
     * @param CardInterface $fourCard
     * @param CardInterface $kicker
     * @return FourInterface
     * @throws NotValidException
     */
    public function createFour(CardInterface $fourCard, CardInterface $kicker): FourInterface;

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
                                    CardInterface $secondLowCard): FullHouseInterface;

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
                                CardInterface $card5): FlushInterface;

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
                                   CardInterface $card5): StraightInterface;


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
                              CardInterface $firstKicker, CardInterface $secondKicker): SetInterface;

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
                                   CardInterface $kicker): TwoPairsInterface;

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
                               CardInterface $thirdKicker): PairInterface;

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
                                   CardInterface $card5): HighCardInterface;
}