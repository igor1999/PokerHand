<?php

namespace PokerHand\Card\Factory;

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
interface FactoryInterface
{
    /**
     * @return FactoryInterface
     */
    public static function getInstance(): FactoryInterface;
}