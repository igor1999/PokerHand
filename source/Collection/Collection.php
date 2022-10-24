<?php

namespace PokerHand\Collection;

use PokerHand\Collection\Exception\DuplicatedCardException;
use PokerHand\Collection\Exception\NotInScopeException;

use PokerHand\Card\Range\RangeEnum;
use PokerHand\Card\Suit\SuitEnum;

use PokerHand\Card\CardInterface;

class Collection implements CollectionInterface
{
    /**
     * @var CardInterface[]
     */
    private array $cards = [];


    /**
     * @param CardInterface[] $cards
     * @throws DuplicatedCardException
     */
    public function __construct(array $cards = [])
    {
        foreach ($cards as $card) {
            $this->add($card);
        }
    }

    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index): bool
    {
        return isset($this->cards[$index]);
    }

    /**
     * @param int $index
     * @return CardInterface
     * @throws NotInScopeException
     */
    public function get(int $index): CardInterface
    {
        if (!$this->has($index)) {
            throw new NotInScopeException($index);
        }

        return $this->cards[$index];
    }

    /**
     * @return CardInterface
     * @throws NotInScopeException
     */
    public function getFirst(): CardInterface
    {
        return $this->get(0);
    }

    /**
     * @return CardInterface
     * @throws NotInScopeException
     */
    public function getLast(): CardInterface
    {
        return $this->get($this->getLength() - 1);
    }

    /**
     * @return CardInterface[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return count($this->cards);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->cards);
    }

    /**
     * @return static
     */
    public function order(): static
    {
        $f = function(CardInterface $card1, CardInterface $card2)
        {
            return match ($card1->isHigher($card2)) {
                true => 1,
                false => -1,
                default => 0,
            };
        };

        usort($this->cards, $f);

        return $this;
    }

    /**
     * @param SuitEnum $suit
     * @return CardInterface[]
     */
    public function findBySuit(SuitEnum $suit): array
    {
        $f = function(CardInterface $card) use ($suit)
        {
            return $card->getSuit() == $suit;
        };

        return array_filter($this->cards, $f);
    }

    /**
     * @return CardInterface[]
     */
    public function findHearts(): array
    {
        return $this->findBySuit(SuitEnum::Hearts);
    }

    /**
     * @return CardInterface[]
     */
    public function findDiamonds(): array
    {
        return $this->findBySuit(SuitEnum::Diamonds);
    }

    /**
     * @return CardInterface[]
     */
    public function findClubs(): array
    {
        return $this->findBySuit(SuitEnum::Clubs);
    }

    /**
     * @return CardInterface[]
     */
    public function findSpades(): array
    {
        return $this->findBySuit(SuitEnum::Spades);
    }

    /**
     * @param RangeEnum $range
     * @return CardInterface[]
     */
    public function findByRange(RangeEnum $range): array
    {
        $f = function(CardInterface $card) use ($range)
        {
            return $card->getRange() == $range;
        };

        return array_filter($this->cards, $f);
    }

    /**
     * @return CardInterface[]
     */
    public function getUniqueRanges(): array
    {
        $result = [];

        foreach (RangeEnum::cases() as $range) {
            $cards = $this->findByRange($range);

            if (!empty($cards)) {
                $result[] = array_shift($cards);
            }
        }

        return $result;
    }

    /**
     * @return CardInterface[]
     */
    public function findStraight(): array
    {
        $result = [];
        $cards = $this->getUniqueRanges();

        if (count($cards) >= 5) {
            for ($highIndex = count($cards) - 1; $highIndex >= 4; $highIndex --) {
                $card1 = $cards[$highIndex - 4];
                $card2 = $cards[$highIndex - 3];
                $card3 = $cards[$highIndex - 2];
                $card4 = $cards[$highIndex - 1];
                $card5 = $cards[$highIndex];

                if ($this->isStraight($card1, $card2, $card3, $card4, $card5)) {
                    $result = [$card1, $card2, $card3, $card4, $card5];
                    break;
                }
            }

            if (empty($result) ) {
                $card1 = $cards[count($cards) - 1];
                $card2 = $cards[0];
                $card3 = $cards[1];
                $card4 = $cards[2];
                $card5 = $cards[3];

                if ($this->isStraight($card1, $card2, $card3, $card4, $card5)) {
                    $result = [$card1, $card2, $card3, $card4, $card5];
                }
            }
        }

        return $result;
    }

    /**
     * @param CardInterface $card1
     * @param CardInterface $card2
     * @param CardInterface $card3
     * @param CardInterface $card4
     * @param CardInterface $card5
     * @return bool
     */
    protected function isStraight(
        CardInterface $card1, CardInterface $card2, CardInterface $card3, CardInterface $card4, CardInterface $card5
        ): bool
    {
        return $card1->isNext($card2, true)
            && $card2->isNext($card3)
            && $card3->isNext($card4)
            && $card4->isNext($card5);
    }

    /**
     * @param CollectionInterface $collection
     * @return bool|null
     */
    public function compare(CollectionInterface $collection): ?bool
    {
        $myCards = $this->order()->getCards();
        $otherCards = $collection->order()->getCards();

        $result = null;

        while(!empty($myCards) && !empty($otherCards)) {
            $myCard = array_pop($myCards);
            $otherCard = array_pop($otherCards);

            $result = $myCard->isHigher($otherCard);
            if (is_bool($result)) {
                break;
            }
        }

        return $result;
    }

    /**
     * @param CardInterface $card
     * @return static
     * @throws DuplicatedCardException
     */
    public function add(CardInterface $card): static
    {
        $this->isDuplicated($card);

        $this->cards[] = $card;

        return $this;
    }

    /**
     * @param CardInterface $newCard
     * @return void
     * @throws DuplicatedCardException
     */
    public function isDuplicated(CardInterface $newCard): void
    {
        $f = function(CardInterface $card) use ($newCard)
        {
            return $card->isIdentical($newCard);
        };

        $cards = array_filter($this->cards, $f);

        if (!empty($cards)) {
            throw new DuplicatedCardException($newCard);
        }
    }

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index): bool
    {
        if ($result = $this->has($index)) {
            array_splice($this->cards, $index, 1);
        }

        return $result;
    }

    /**
     * @return static
     */
    public function clean(): static
    {
        $this->cards = [];

        return $this;
    }
}