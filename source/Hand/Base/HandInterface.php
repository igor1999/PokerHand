<?php

namespace PokerHand\Hand\Base;

use PokerHand\Hand\Ranking\RankingEnum;

interface HandInterface
{
    /**
     * @return RankingEnum
     */
    public function getRanking(): RankingEnum;

    /**
     * @param HandInterface $hand
     * @return bool|null
     */
    public function compare(HandInterface $hand): ?bool;
}