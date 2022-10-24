<?php

namespace PokerHand\Card\Factory;

trait FactoryAwareTrait
{
    /**
     * @return FactoryInterface
     */
    protected function getCardFactory(): FactoryInterface
    {
        return Factory::getInstance();
    }
}