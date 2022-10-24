<?php

namespace PokerHand\Hand\Factory;

trait FactoryAwareTrait
{
    /**
     * @return FactoryInterface
     */
    protected function getHandFactory(): FactoryInterface
    {
        return Factory::getInstance();
    }
}