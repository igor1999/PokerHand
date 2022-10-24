<?php

namespace PokerHand\Hand\TwoPairs;

use PokerHand\Collection\Exception\DuplicatedCardException;
use PokerHand\Hand\Exception\NotValidException;

use PokerHand\Hand\Ranking\RankingEnum;

use PokerHand\Hand\Base\AbstractHand;

use PokerHand\Card\CardInterface;
use PokerHand\Hand\Base\HandInterface;

class TwoPairs extends AbstractHand implements TwoPairsInterface
{
    /**
     * @var CardInterface
     */
    private readonly CardInterface $highPairCard1;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $highPairCard2;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $lowPairCard1;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $lowPairCard2;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $kicker;


    /**
     * @param CardInterface $firstPairCard1
     * @param CardInterface $firstPairCard2
     * @param CardInterface $secondPairCard1
     * @param CardInterface $secondPairCard2
     * @param CardInterface $kicker
     * @throws NotValidException
     * @throws DuplicatedCardException
     */
    public function __construct(CardInterface $firstPairCard1, CardInterface $firstPairCard2,
                                CardInterface $secondPairCard1, CardInterface $secondPairCard2,
                                CardInterface $kicker)
    {
        $this->createCollectionFrom5($firstPairCard1, $firstPairCard2, $secondPairCard1, $secondPairCard2, $kicker);

        $condition1 = $firstPairCard1->getRange() == $firstPairCard2->getRange();
        $condition2 = $secondPairCard1->getRange() == $secondPairCard2->getRange();

        $condition3 = $firstPairCard1->getRange() != $secondPairCard1->getRange();

        $condition4 = $firstPairCard1->getRange() != $kicker->getRange();
        $condition5 = $secondPairCard1->getRange() != $kicker->getRange();

        if (!($condition1 && $condition2 && $condition3 && $condition4 && $condition5)) {
            throw new NotValidException('Two Pairs');
        }

        if ($firstPairCard1->getRange() > $secondPairCard1->getRange()) {
            $this->highPairCard1 = $firstPairCard1;
            $this->highPairCard2 = $firstPairCard2;

            $this->lowPairCard1 = $secondPairCard1;
            $this->lowPairCard2 = $secondPairCard2;
        } else {
            $this->highPairCard1 = $secondPairCard1;
            $this->highPairCard2 = $secondPairCard2;

            $this->lowPairCard1 = $firstPairCard1;
            $this->lowPairCard2 = $firstPairCard2;
        }

        $this->kicker = $kicker;
    }

    /**
     * @return RankingEnum
     */
    public function getRanking(): RankingEnum
    {
        return RankingEnum::TwoPairs;
    }

    /**
     * @return CardInterface
     */
    public function getHighPairCard1(): CardInterface
    {
        return $this->highPairCard1;
    }

    /**
     * @return CardInterface
     */
    public function getHighPairCard2(): CardInterface
    {
        return $this->highPairCard2;
    }

    /**
     * @return CardInterface
     */
    public function getLowPairCard1(): CardInterface
    {
        return $this->lowPairCard1;
    }

    /**
     * @return CardInterface
     */
    public function getLowPairCard2(): CardInterface
    {
        return $this->lowPairCard2;
    }

    /**
     * @return CardInterface
     */
    public function getKicker(): CardInterface
    {
        return $this->kicker;
    }

    /**
     * @param HandInterface $hand
     * @return bool|null
     * @throws DuplicatedCardException
     */
    public function compare(HandInterface $hand): ?bool
    {
        if ($hand instanceof TwoPairsInterface) {
            $myCards = $this->createCollection(
                [$this->getKicker(), $this->getLowPairCard1(), $this->getHighPairCard1()]);

            $otherCards = $this->createCollection(
                [$hand->getKicker(), $hand->getLowPairCard1(), $hand->getHighPairCard1()]);

            $result = $myCards->compare($otherCards);
        } else {
            $result = $this->compareByRanking($hand);
        }

        return $result;
    }
}