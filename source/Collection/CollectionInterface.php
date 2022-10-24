<?php

namespace PokerHand\Collection;

use PokerHand\Collection\Exception\DuplicatedCardException;
use PokerHand\Collection\Exception\NotInScopeException;

use PokerHand\Card\Range\RangeEnum;
use PokerHand\Card\Suit\SuitEnum;

use PokerHand\Card\CardInterface;

interface CollectionInterface
{
    /**
     * @param int $index
     * @return bool
     */
    public function has(int $index): bool;

    /**
     * @param int $index
     * @return CardInterface
     * @throws NotInScopeException
     */
    public function get(int $index): CardInterface;

    /**
     * @return CardInterface
     * @throws NotInScopeException
     */
    public function getFirst(): CardInterface;

    /**
     * @return CardInterface
     * @throws NotInScopeException
     */
    public function getLast(): CardInterface;

    /**
     * @return CardInterface[]
     */
    public function getCards(): array;

    /**
     * @return int
     */
    public function getLength(): int;

    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @return static
     */
    public function order(): static;

    /**
     * @param SuitEnum $suit
     * @return CardInterface[]
     */
    public function findBySuit(SuitEnum $suit): array;

    /**
     * @return CardInterface[]
     */
    public function findHearts(): array;

    /**
     * @return CardInterface[]
     */
    public function findDiamonds(): array;

    /**
     * @return CardInterface[]
     */
    public function findClubs(): array;

    /**
     * @return CardInterface[]
     */
    public function findSpades(): array;

    /**
     * @param RangeEnum $range
     * @return CardInterface[]
     */
    public function findByRange(RangeEnum $range): array;

    /**
     * @return CardInterface[]
     */
    public function getUniqueRanges(): array;

    /**
     * @return CardInterface[]
     */
    public function findStraight(): array;

    /**
     * @param CollectionInterface $collection
     * @return bool|null
     */
    public function compare(CollectionInterface $collection): ?bool;

    /**
     * @param CardInterface $card
     * @return static
     * @throws DuplicatedCardException
     */
    public function add(CardInterface $card): static;

    /**
     * @param CardInterface $newCard
     * @return void
     * @throws DuplicatedCardException
     */
    public function isDuplicated(CardInterface $newCard): void;

    /**
     * @param int $index
     * @return bool
     */
    public function remove(int $index): bool;

    /**
     * @return static
     */
    public function clean(): static;
}