<?php

namespace PokerHand\Hand\Base\Part\CommonCards;

use PokerHand\Card\CardInterface;

trait CommonCardsTrait
{
    /**
     * @var CardInterface
     */
    private readonly CardInterface $highCard;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $secondCard;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $thirdCard;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $fourthCard;

    /**
     * @var CardInterface
     */
    private readonly CardInterface $fifthCard;


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
        return $this->secondCard;
    }

    /**
     * @return CardInterface
     */
    public function getThirdCard(): CardInterface
    {
        return $this->thirdCard;
    }

    /**
     * @return CardInterface
     */
    public function getFourthCard(): CardInterface
    {
        return $this->fourthCard;
    }

    /**
     * @return CardInterface
     */
    public function getFifthCard(): CardInterface
    {
        return $this->fifthCard;
    }
}