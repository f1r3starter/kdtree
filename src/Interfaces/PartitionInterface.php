<?php

declare(strict_types=1);

namespace KDTree\Interfaces;

/**
 * Interface PartitionInterface
 *
 * @package KDTree\Interfaces
 */
interface PartitionInterface
{
    /**
     * @return int
     */
    public function getDimensions(): int;

    /**
     * @param int $dimension
     *
     * @return float
     */
    public function getDMin(int $dimension): float;

    /**
     * @param int $dimension
     *
     * @return float
     */
    public function getDMax(int $dimension): float;

    /**
     * @param PointInterface $point
     *
     * @return bool
     */
    public function contains(PointInterface $point): bool;

    /**
     * @param PartitionInterface $partition
     *
     * @return bool
     */
    public function intersects(PartitionInterface $partition): bool;

    /**
     * @param PointInterface $point
     *
     * @return float
     */
    public function distanceToPoint(PointInterface $point): float;

    /**
     * @param PartitionInterface $partition
     *
     * @return bool
     */
    public function equals(PartitionInterface $partition): bool;
}
