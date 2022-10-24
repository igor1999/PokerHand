<?php

namespace PokerHand\Hand\FullHouse;

use PokerHand\Collection\Exception\DuplicatedCardException;
use PokerHand\Hand\Exception\NotValidException;

use PokerHand\Hand\Ranking\RankingEnum;

use PokerHand\Hand\Base\AbstractHand;

use PokerHand\Card\CardInterface;
use PokerHand\Hand\Base\HandInterface;

class FullHouse extends AbstractHand implements FullHouseInterface
{
    /**
     * @var CardInterface
     */
    private readonly CardInterface $firstHighCard;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $secondHighCard;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $thirdHighCard;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $firstLowCard;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $secondLowCard;


    /**
     * @param CardInterface $firstHighCard
     * @param CardInterface $secondHighCard
     * @param CardInterface $thirdHighCard
     * @param CardInterface $firstLowCard
     * @param CardInterface $secondLowCard
     * @throws NotValidException
     * @throws DuplicatedCardException
     */
    public function __construct(CardInterface $firstHighCard,
                                CardInterface $secondHighCard, CardInterface $thirdHighCard,
                                CardInterface $firstLowCard, CardInterface $secondLowCard)
    {
        $this->createCollectionFrom5($firstHighCard, $secondHighCard, $thirdHighCard, $firstLowCard, $secondLowCard);

        $condition1 = $firstHighCard->getRange() == $secondHighCard->getRange();
        $condition2 = $firstHighCard->getRange() == $thirdHighCard->getRange();

        $condition3 = $firstLowCard->getRange() == $secondLowCard->getRange();

        $condition4 = $firstHighCard->getRange() != $firstLowCard->getRange();

        if (!($condition1 && $condition2 && $condition3 && $condition4)) {
            throw new NotValidException('Full House');
        }

        $this->firstHighCard = $firstHighCard;
        $this->secondHighCard = $secondHighCard;
        $this->thirdHighCard = $thirdHighCard;
        $this->firstLowCard = $firstLowCard;
        $this->secondLowCard = $secondLowCard;
    }

    /**
     * @return RankingEnum
     */
    public function getRanking(): RankingEnum
    {
        return RankingEnum::FullHouse;
    }

    /**
     * @return CardInterface
     */
    public function getFirstHighCard(): CardInterface
    {
        return $this->firstHighCard;
    }

    /**
     * @return CardInterface
     */
    public function getSecondHighCard(): CardInterface
    {
        return $this->secondHighCard;
    }

    /**
     * @return CardInterface
     */
    public function getThirdHighCard(): CardInterface
    {
        return $this->thirdHighCard;
    }

    /**
     * @return CardInterface
     */
    public function getFirstLowCard(): CardInterface
    {
        return $this->firstLowCard;
    }

    /**
     * @return CardInterface
     */
    public function getSecondLowCard(): CardInterface
    {
        return $this->secondLowCard;
    }

    /**
     * @param HandInterface $hand
     * @return bool|null
     * @throws DuplicatedCardException
     */
    public function compare(HandInterface $hand): ?bool
    {
        if ($hand instanceof FullHouseInterface) {
            $myCards = $this->createCollection([$this->getFirstLowCard(), $this->getFirstHighCard()]);

            $otherCards = $this->createCollection([$hand->getFirstLowCard(), $hand->getFirstHighCard()]);

            $result = $myCards->compare($otherCards);
        } else {
            $result = $this->compareByRanking($hand);
        }

        return $result;
    }
}