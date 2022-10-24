<?php

namespace PokerHand\Hand\Pair;

use PokerHand\Collection\Exception\DuplicatedCardException;
use PokerHand\Collection\Exception\NotInScopeException;
use PokerHand\Hand\Exception\NotValidException;

use PokerHand\Hand\Ranking\RankingEnum;

use PokerHand\Hand\Base\AbstractHand;

use PokerHand\Card\CardInterface;
use PokerHand\Hand\Base\HandInterface;

class Pair extends AbstractHand implements PairInterface
{
    /**
     * @var CardInterface
     */
    private readonly CardInterface $pairCard1;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $pairCard2;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $firstKicker;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $secondKicker;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $thirdKicker;


    /**
     * @param CardInterface $pairCard1
     * @param CardInterface $pairCard2
     * @param CardInterface $firstKicker
     * @param CardInterface $secondKicker
     * @param CardInterface $thirdKicker
     * @throws NotValidException
     * @throws DuplicatedCardException
     * @throws NotInScopeException
     */
    public function __construct(CardInterface $pairCard1, CardInterface $pairCard2,
                                CardInterface $firstKicker, CardInterface $secondKicker, CardInterface $thirdKicker)
    {
        $cards = $this->createCollectionFrom5($pairCard1, $pairCard2, $firstKicker, $secondKicker, $thirdKicker);

        $condition1 = $pairCard1->getRange() == $pairCard2->getRange();

        $cards->remove(0);
        $condition2 = $this->isRangesUnique($cards);

        if (!($condition1 && $condition2)) {
            throw new NotValidException('Pair');
        }

        $this->pairCard1 = $pairCard1;
        $this->pairCard2 = $pairCard2;

        $cards->order();
        $this->firstKicker = $cards->get(2);
        $this->secondKicker = $cards->get(1);
        $this->thirdKicker = $cards->get(0);
    }

    /**
     * @return RankingEnum
     */
    public function getRanking(): RankingEnum
    {
        return RankingEnum::Pair;
    }

    /**
     * @return CardInterface
     */
    public function getPairCard1(): CardInterface
    {
        return $this->pairCard1;
    }

    /**
     * @return CardInterface
     */
    public function getPairCard2(): CardInterface
    {
        return $this->pairCard2;
    }

    /**
     * @return CardInterface
     */
    public function getFirstKicker(): CardInterface
    {
        return $this->firstKicker;
    }

    /**
     * @return CardInterface
     */
    public function getSecondKicker(): CardInterface
    {
        return $this->secondKicker;
    }

    /**
     * @return CardInterface
     */
    public function getThirdKicker(): CardInterface
    {
        return $this->thirdKicker;
    }

    /**
     * @param HandInterface $hand
     * @return bool|null
     * @throws DuplicatedCardException
     */
    public function compare(HandInterface $hand): ?bool
    {
        if ($hand instanceof PairInterface) {
            $myCards = $this->createCollection(
                [$this->getThirdKicker(), $this->getSecondKicker(), $this->getFirstKicker(), $this->getPairCard1()]);

            $otherCards = $this->createCollection(
                [$hand->getThirdKicker(), $hand->getSecondKicker(), $hand->getFirstKicker(), $hand->getPairCard1()]);

            $result = $myCards->compare($otherCards);
        } else {
            $result = $this->compareByRanking($hand);
        }

        return $result;
    }
}