<?php

namespace PokerHand\Hand\Ranking;

enum RankingEnum : int
{
    case HighCard = 1;
    case Pair = 2;
    case TwoPairs = 3;
    case Set = 4;
    case Straight = 5;
    case Flush = 6;
    case FullHouse = 7;
    case Four = 8;
    case StraightFlush = 9;
}
