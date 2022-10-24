<?php

namespace PokerHand\Hand\Four;

use PokerHand\Collection\Exception\DuplicatedCardException;
use PokerHand\Hand\Exception\NotValidException;

use PokerHand\Card\Suit\SuitEnum;
use PokerHand\Hand\Ranking\RankingEnum;

use PokerHand\Hand\Base\AbstractHand;

use PokerHand\Card\CardInterface;
use PokerHand\Hand\Base\HandInterface;

class Four extends AbstractHand implements FourInterface
{
    /**
     * @var CardInterface
     */
    private readonly CardInterface $fourCard;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $kicker;


    /**
     * @param CardInterface $fourCard
     * @param CardInterface $kicker
     * @throws NotValidException
     */
    public function __construct(CardInterface $fourCard, CardInterface $kicker)
    {
        if ($fourCard->getRange() == $kicker->getRange()) {
            throw new NotValidException('Four');
        }

        $this->fourCard = $fourCard;
        $this->kicker = $kicker;
    }

    /**
     * @return RankingEnum
     */
    public function getRanking(): RankingEnum
    {
        return RankingEnum::Four;
    }

    /**
     * @return CardInterface
     */
    public function getFourCard(): CardInterface
    {
        return $this->fourCard;
    }

    /**
     * @return CardInterface[]
     */
    public function getFourCards(): array
    {
        $result = [];

        foreach (SuitEnum::cases() as $suit) {
            $result[$suit->name] = $this->createCard($suit, $this->getFourCard()->getRange());
        }

        return $result;
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
        if ($hand instanceof FourInterface) {
            $myCards = $this->createCollection([$this->getKicker(), $this->getFourCard()]);

            $otherCards = $this->createCollection([$hand->getKicker(), $hand->getFourCard()]);

            $result = $myCards->compare($otherCards);
        } else {
            $result = $this->compareByRanking($hand);
        }

        return $result;
    }
}