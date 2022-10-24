<?php

namespace PokerHand\Card\Factory;

use PokerHand\Card\Range\RangeEnum;
use PokerHand\Card\Suit\SuitEnum;

use PokerHand\Card\Card;

use PokerHand\Card\CardInterface;

/**
 * @method CardInterface createTwoOfHearts()
 * @method CardInterface createTwoOfDiamonds()
 * @method CardInterface createTwoOfClubs()
 * @method CardInterface createTwoOfSpades()
 *
 * @method CardInterface createThreeOfHearts()
 * @method CardInterface createThreeOfDiamonds()
 * @method CardInterface createThreeOfClubs()
 * @method CardInterface createThreeOfSpades()
 *
 * @method CardInterface createFourOfHearts()
 * @method CardInterface createFourOfDiamonds()
 * @method CardInterface createFourOfClubs()
 * @method CardInterface createFourOfSpades()
 *
 * @method CardInterface createFiveOfHearts()
 * @method CardInterface createFiveOfDiamonds()
 * @method CardInterface createFiveOfClubs()
 * @method CardInterface createFiveOfSpades()
 *
 * @method CardInterface createSixOfHearts()
 * @method CardInterface createSixOfDiamonds()
 * @method CardInterface createSixOfClubs()
 * @method CardInterface createSixOfSpades()
 *
 * @method CardInterface createSevenOfHearts()
 * @method CardInterface createSevenOfDiamonds()
 * @method CardInterface createSevenOfClubs()
 * @method CardInterface createSevenOfSpades()
 *
 * @method CardInterface createEightOfHearts()
 * @method CardInterface createEightOfDiamonds()
 * @method CardInterface createEightOfClubs()
 * @method CardInterface createEightOfSpades()
 *
 * @method CardInterface createNineOfHearts()
 * @method CardInterface createNineOfDiamonds()
 * @method CardInterface createNineOfClubs()
 * @method CardInterface createNineOfSpades()
 *
 * @method CardInterface createTenOfHearts()
 * @method CardInterface createTenOfDiamonds()
 * @method CardInterface createTenOfClubs()
 * @method CardInterface createTenOfSpades()
 *
 * @method CardInterface createJackOfHearts()
 * @method CardInterface createJackOfDiamonds()
 * @method CardInterface createJackOfClubs()
 * @method CardInterface createJackOfSpades()
 *
 * @method CardInterface createQueenOfHearts()
 * @method CardInterface createQueenOfDiamonds()
 * @method CardInterface createQueenOfClubs()
 * @method CardInterface createQueenOfSpades()
 *
 * @method CardInterface createKingOfHearts()
 * @method CardInterface createKingOfDiamonds()
 * @method CardInterface createKingOfClubs()
 * @method CardInterface createKingOfSpades()
 *
 * @method CardInterface createAceOfHearts()
 * @method CardInterface createAceOfDiamonds()
 * @method CardInterface createAceOfClubs()
 * @method CardInterface createAceOfSpades()
 */
class Factory implements FactoryInterface
{
    const PREFIX_REG_EXP = '/\bcreate/';

    const SEPARATOR = 'Of';


    /**
     * @var FactoryInterface
     */
    private static FactoryInterface $instance;


    /**
     * @return FactoryInterface
     */
    public static function getInstance(): FactoryInterface
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return CardInterface
     */
    public function __call(string $method, array $arguments = [])
    {
        $contents = preg_replace(static::PREFIX_REG_EXP, '', $method);
        $contents = explode(static::SEPARATOR, $contents);

        list($range, $suit) = $contents;

        $range = constant(RangeEnum::class . '::' . $range);
        $suit =constant(SuitEnum::class . '::' . $suit);

        return $this->createCard($suit, $range);
    }

    /**
     * @param SuitEnum $suit
     * @param RangeEnum $range
     * @return Card
     */
    protected function createCard(SuitEnum $suit, RangeEnum $range): Card
    {
        return new Card($suit, $range);
    }
}