<?php

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
     * @return PointsListInterface
     */
    public function points(): PointsListInterface;

    /**
     * @param PartitionInterface $partition
     *
     * @return PointsListInterface
     */
    public function range(PartitionInterface $partition): PointsListInterface;

    /**
     * @param PointInterface $point
     *
     * @return PointInterface|null
     */
    public function nearest(PointInterface $point): ?PointInterface;

    /**
     * @return int
     */
    public function getDimensions(): int;

    /**
     * @return NodeInterface|null
     */
    public function getRoot(): ?NodeInterface;
}
