<?php

namespace PokerHand\Hand\HighCard;

use PokerHand\Collection\Exception\DuplicatedCardException;
use PokerHand\Collection\Exception\NotInScopeException;
use PokerHand\Hand\Exception\NotValidException;

use PokerHand\Hand\Ranking\RankingEnum;

use PokerHand\Hand\Base\AbstractHand;

use PokerHand\Hand\Base\Part\CommonCards\CommonCardsTrait;

use PokerHand\Card\CardInterface;
use PokerHand\Hand\Base\HandInterface;

class HighCard extends AbstractHand implements HighCardInterface
{
    use CommonCardsTrait;


    /**
     * @param CardInterface $card1
     * @param CardInterface $card2
     * @param CardInterface $card3
     * @param CardInterface $card4
     * @param CardInterface $card5
     * @throws NotValidException
     * @throws DuplicatedCardException
     * @throws NotInScopeException
     */
    public function __construct(CardInterface $card1, CardInterface $card2, CardInterface $card3,
                                CardInterface $card4, CardInterface $card5)
    {
        $cards = $this->createCollectionFrom5($card1, $card2, $card3, $card4, $card5)->order();

        if (!$this->isRangesUnique($cards)) {
            throw new NotValidException('High Card');
        }

        if ($this->isStraight($cards)) {
            throw new NotValidException('High Card');
        }

        if ($this->isFlush($cards)) {
            throw new NotValidException('High Card');
        }

        $this->highCard = $cards->get(4);
        $this->secondCard = $cards->get(3);
        $this->thirdCard = $cards->get(2);
        $this->fourthCard = $cards->get(1);
        $this->fifthCard = $cards->get(0);
    }

    /**
     * @return RankingEnum
     */
    public function getRanking(): RankingEnum
    {
        return RankingEnum::HighCard;
    }

    /**
     * @param HandInterface $hand
     * @return bool|null
     * @throws DuplicatedCardException
     */
    public function compare(HandInterface $hand): ?bool
    {
        if ($hand instanceof HighCardInterface) {
            $myCards = $this->createCollectionFrom5(
                $this->getFifthCard(), $this->getFourthCard(), $this->getThirdCard(),
                $this->getSecondCard(), $this->getHighCard());

            $otherCards = $this->createCollectionFrom5(
                $hand->getFifthCard(), $hand->getFourthCard(), $hand->getThirdCard(),
                $hand->getSecondCard(), $hand->getHighCard());

            $result = $myCards->compare($otherCards);
        } else {
            $result = $this->compareByRanking($hand);
        }

        return $result;
    }
}