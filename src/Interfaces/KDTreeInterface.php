<?php

declare(strict_types=1);

namespace KDTree\Interfaces;

interface KDTreeInterface
{
    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @return int
     */
    public function size(): int;

    /**
     * @param PointInterface $point
     *
     * @return KDTreeInterface
     */
    public function put(PointInterface $point): KDTreeInterface;

    /**
     * @param PointInterface $point
     *
     * @return bool
     */
    public function contains(PointInterface $point): bool;

    /**
     * @return PointsListInterface<PointInterface>
     */
    public function points(): PointsListInterface;

    /**
     * @param PointInterface $point
     *
     * @return KDTreeInterface
     */
    public function delete(PointInterface $point): KDTreeInterface;

    /**
     * @return int
     */
    public function getDimensions(): int;

    /**
     * @return NodeInterface|null
     */
    public function getRoot(): ?NodeInterface;
}
