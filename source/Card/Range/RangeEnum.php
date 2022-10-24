<?php

namespace PokerHand\Card\Range;

enum RangeEnum : int
{
    case Two = 2;
    case Three = 3;
    case Four = 4;
    case Five = 5;
    case Six = 6;
    case Seven = 7;
    case Eight = 8;
    case Nine = 9;
    case Ten = 10;
    case Jack = 11;
    case Queen = 12;
    case King = 13;
    case Ace = 14;


    /**
     * @param RangeEnum $range
     * @return bool|null
     */
    public function IsHigher(self $range): ?bool
    {
        return match (true) {
            $this->value > $range->value => true,
            $this->value < $range->value => false,
            default => null,
        };
    }

    /**
     * @param RangeEnum $range
     * @param bool $aceAsOne
     * @return bool
     */
    public function isNext(self $range, bool $aceAsOne = false): bool
    {
        return (($range->value - $this->value) == 1) || ($aceAsOne && ($this == self::Ace) && ($range == self::Two));
    }

    /**
     * @return self
     */
    public function getNext(): self
    {
        if ($this == self::Ace) {
            $result = self::Two;
        } else {
            $value = $this->value + 1;
            $result = self::from($value);
        }

        return $result;
    }

    /**
     * @return self
     */
    public function getPrevious(): self
    {
        if ($this == self::Two) {
            $result = self::Ace;
        } else {
            $value = $this->value - 1;
            $result = self::from($value);
        }

        return $result;
    }
}
