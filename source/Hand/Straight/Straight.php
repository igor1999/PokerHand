<?php

namespace PokerHand\Hand\Straight;

use PokerHand\Collection\Exception\DuplicatedCardException;
use PokerHand\Collection\Exception\NotInScopeException;
use PokerHand\Hand\Exception\NotValidException;

use PokerHand\Hand\Ranking\RankingEnum;

use PokerHand\Hand\Base\AbstractHand;

use PokerHand\Hand\Base\Part\CommonCards\CommonCardsTrait;

use PokerHand\Card\CardInterface;
use PokerHand\Hand\Base\HandInterface;

class Straight extends AbstractHand implements StraightInterface
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

        if (!$this->isStraight($cards)) {
            throw new NotValidException('Straight');
        }

        if ($this->isFlush($cards)) {
            throw new NotValidException('Straight');
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
        return RankingEnum::Straight;
    }

    /**
     * @param HandInterface $hand
     * @return bool|null
     */
    public function compare(HandInterface $hand): ?bool
    {
        if ($hand instanceof StraightInterface) {
            $result = $this->getHighCard()->isHigher($hand->getHighCard());
        } else {
            $result = $this->compareByRanking($hand);
        }

        return $result;
    }
}