<?php

use PokerHand\Card\Factory\Factory;
use PokerHand\Collection\Collection;
use PokerHand\Finder\Finder;

include __DIR__ . '/vendor/autoload.php';

$cardFactory = Factory::getInstance();

$straightFlush = [
    $cardFactory->createTenOfDiamonds(), $cardFactory->createJackOfDiamonds(), $cardFactory->createNineOfDiamonds(),
    $cardFactory->createFourOfSpades(), $cardFactory->createSevenOfDiamonds(), $cardFactory->createJackOfSpades(),
    $cardFactory->createEightOfDiamonds(),
];

$four = [
    $cardFactory->createTwoOfClubs(), $cardFactory->createJackOfClubs(), $cardFactory->createJackOfDiamonds(),
    $cardFactory->createFourOfSpades(), $cardFactory->createNineOfHearts(), $cardFactory->createJackOfSpades(),
    $cardFactory->createJackOfHearts(),
];

$fullHouse = [
    $cardFactory->createThreeOfClubs(), $cardFactory->createQueenOfDiamonds(), $cardFactory->createThreeOfSpades(),
    $cardFactory->createFourOfClubs(), $cardFactory->createThreeOfDiamonds(), $cardFactory->createJackOfClubs(),
    $cardFactory->createJackOfHearts(),
];

$flush = [
    $cardFactory->createTwoOfClubs(), $cardFactory->createQueenOfDiamonds(), $cardFactory->createTenOfSpades(),
    $cardFactory->createFourOfClubs(), $cardFactory->createNineOfClubs(), $cardFactory->createJackOfClubs(),
    $cardFactory->createFiveOfClubs(),
];

$straight = [
    $cardFactory->createTenOfClubs(), $cardFactory->createJackOfClubs(), $cardFactory->createNineOfDiamonds(),
    $cardFactory->createFourOfSpades(), $cardFactory->createSevenOfHearts(), $cardFactory->createJackOfSpades(),
    $cardFactory->createEightOfDiamonds(),
];

$set = [
    $cardFactory->createTwoOfClubs(), $cardFactory->createJackOfClubs(), $cardFactory->createJackOfDiamonds(),
    $cardFactory->createFourOfSpades(), $cardFactory->createNineOfHearts(), $cardFactory->createJackOfSpades(),
    $cardFactory->createFiveOfDiamonds(),
];

$twoPairs = [
    $cardFactory->createTwoOfClubs(), $cardFactory->createTwoOfDiamonds(), $cardFactory->createTenOfSpades(),
    $cardFactory->createTenOfClubs(), $cardFactory->createNineOfHearts(), $cardFactory->createJackOfSpades(),
    $cardFactory->createAceOfDiamonds(),
];

$pair = [
    $cardFactory->createTwoOfClubs(), $cardFactory->createQueenOfDiamonds(), $cardFactory->createQueenOfSpades(),
    $cardFactory->createFourOfSpades(), $cardFactory->createNineOfHearts(), $cardFactory->createJackOfSpades(),
    $cardFactory->createFiveOfDiamonds(),
];

$highCard = [
    $cardFactory->createTwoOfClubs(), $cardFactory->createQueenOfDiamonds(), $cardFactory->createTenOfSpades(),
    $cardFactory->createFourOfSpades(), $cardFactory->createNineOfHearts(), $cardFactory->createJackOfSpades(),
    $cardFactory->createFiveOfDiamonds(),
];

$cards = new Collection(
    $straightFlush
    //$four
    //$fullHouse
    //$flush
    //$straight
    //$set
    //$twoPairs
    //$pair
    //$highCard
);

$hand = (new Finder($cards))->find();

var_dump($hand);
