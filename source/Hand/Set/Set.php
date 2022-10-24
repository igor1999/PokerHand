<?php

namespace PokerHand\Hand\Set;

use PokerHand\Collection\Exception\DuplicatedCardException;
use PokerHand\Hand\Exception\NotValidException;

use PokerHand\Hand\Ranking\RankingEnum;

use PokerHand\Hand\Base\AbstractHand;

use PokerHand\Card\CardInterface;
use PokerHand\Hand\Base\HandInterface;

class Set extends AbstractHand implements SetInterface
{
    /**
     * @var CardInterface
     */
    private readonly CardInterface $firstSetCard;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $secondSetCard;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $thirdSetCard;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $highKicker;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $lowKicker;


    /**
     * @param CardInterface $firstSetCard
     * @param CardInterface $secondSetCard
     * @param CardInterface $thirdSetCard
     * @param CardInterface $firstKicker
     * @param CardInterface $secondKicker
     * @throws NotValidException
     * @throws DuplicatedCardException
     */
    public function __construct(CardInterface $firstSetCard,
                                CardInterface $secondSetCard, CardInterface $thirdSetCard,
                                CardInterface $firstKicker, CardInterface $secondKicker)
    {
        $this->createCollectionFrom5($firstSetCard, $secondSetCard, $thirdSetCard, $firstKicker, $secondKicker);

        $condition1 = $firstSetCard->getRange() == $secondSetCard->getRange();
        $condition2 = $firstSetCard->getRange() == $thirdSetCard->getRange();

        $condition3 = $firstKicker->getRange() != $secondKicker->getRange();

        $condition4 = $firstSetCard->getRange() != $firstKicker->getRange();
        $condition5 = $firstSetCard->getRange() != $secondKicker->getRange();

        if (!($condition1 && $condition2 && $condition3 && $condition4 && $condition5)) {
            throw new NotValidException('Set');
        }

        $this->firstSetCard = $firstSetCard;
        $this->secondSetCard = $secondSetCard;
        $this->thirdSetCard = $thirdSetCard;

        $kickerCondition = $firstKicker->getRange() > $secondKicker->getRange();
        $this->highKicker = $kickerCondition ? $firstKicker : $secondKicker;
        $this->lowKicker = $kickerCondition ? $secondKicker : $firstKicker;
    }

    /**
     * @return RankingEnum
     */
    public function getRanking(): RankingEnum
    {
        return RankingEnum::Set;
    }

    /**
     * @return CardInterface
     */
    public function getFirstSetCard(): CardInterface
    {
        return $this->firstSetCard;
    }

    /**
     * @return CardInterface
     */
    public function getSecondSetCard(): CardInterface
    {
        return $this->secondSetCard;
    }

    /**
     * @return CardInterface
     */
    public function getThirdSetCard(): CardInterface
    {
        return $this->thirdSetCard;
    }

    /**
     * @return CardInterface
     */
    public function getHighKicker(): CardInterface
    {
        return $this->highKicker;
    }

    /**
     * @return CardInterface
     */
    public function getLowKicker(): CardInterface
    {
        return $this->lowKicker;
    }

    /**
     * @param HandInterface $hand
     * @return bool|null
     * @throws DuplicatedCardException
     */
    public function compare(HandInterface $hand): ?bool
    {
        if ($hand instanceof SetInterface) {
            $myCards = $this->createCollection(
                [$this->getLowKicker(), $this->getHighKicker(), $this->getFirstSetCard()]);

            $otherCards = $this->createCollection(
                [$hand->getLowKicker(), $hand->getHighKicker(), $hand->getFirstSetCard()]);

            $result = $myCards->compare($otherCards);
        } else {
            $result = $this->compareByRanking($hand);
        }

        return $result;
    }
}