<?php

namespace PokerHand\Hand\StraightFlush;

use PokerHand\Hand\Exception\NotValidException;

use PokerHand\Card\Range\RangeEnum;
use PokerHand\Hand\Ranking\RankingEnum;

use PokerHand\Hand\Base\AbstractHand;

use PokerHand\Card\CardInterface;
use PokerHand\Hand\Base\HandInterface;

class StraightFlush extends AbstractHand implements StraightFlushInterface
{
    /**
     * @var CardInterface
     */
    private readonly CardInterface $highCard;


    /**
     * @param CardInterface $highCard
     * @throws NotValidException
     */
    public function __construct(CardInterface $highCard)
    {
        if ($highCard->getRange()->value < RangeEnum::Five->value) {
            throw new NotValidException('Straight Flush');
        }

        $this->highCard = $highCard;
    }

    /**
     * @return RankingEnum
     */
    public function getRanking(): RankingEnum
    {
        return RankingEnum::StraightFlush;
    }

    /**
     * @param int $position
     * @return CardInterface
     */
    protected function createLowerCard(int $position): CardInterface
    {
        $suit = $this->getHighCard()->getSuit();

        $range = $this->getHighCard()->getRange();
        for ($i = 1; $i <= $position - 1; $i++) {
            $range = $range->getPrevious();
        }

        return $this->createCard($suit, $range);
    }

    /**
     * @return CardInterface
     */
    public function getHighCard(): CardInterface
    {
        return $this->highCard;
    }

    /**
     * @return CardInterface
     */
    public function getSecondCard(): CardInterface
    {
        return $this->createLowerCard(2);
    }

    /**
     * @return CardInterface
     */
    public function getThirdCard(): CardInterface
    {
        return $this->createLowerCard(3);
    }

    /**
     * @return CardInterface
     */
    public function getFourthCard(): CardInterface
    {
        return $this->createLowerCard(4);
    }

    /**
     * @return CardInterface
     */
    public function getFifthCard(): CardInterface
    {
        return $this->createLowerCard(5);
    }

    /**
     * @param HandInterface $hand
     * @return bool|null
     */
    public function compare(HandInterface $hand): ?bool
    {
        if ($hand instanceof StraightFlushInterface) {
            $result = $this->getHighCard()->isHigher($hand->getHighCard());
        } else {
            $result = $this->compareByRanking($hand);
        }

        return $result;
    }
}