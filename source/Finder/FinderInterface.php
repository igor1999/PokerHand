<?php

namespace PokerHand\Finder;

use PokerHand\Collection\Exception\DuplicatedCardException;
use PokerHand\Collection\Exception\NotInScopeException;
use PokerHand\Hand\Exception\NotValidException;

use PokerHand\Hand\Base\HandInterface;

interface FinderInterface
{
    /**
     * @return HandInterface
     * @throws DuplicatedCardException
     * @throws NotInScopeException
     * @throws NotValidException
     */
    public function find(): HandInterface;
}