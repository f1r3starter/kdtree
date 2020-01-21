<?php

declare(strict_types=1);

namespace KDTree\Interfaces;

interface PointsListInterface extends \Iterator, \Countable
{
    /**
     * @return int
     */
    public function getDimensions(): int;

    /**
     * @param PointInterface $point
     *
     * @return PointsListInterface<PointInterface>
     */
    public function addPoint(PointInterface $point): PointsListInterface;

    /**
     * @param PointInterface $point
     *
     * @return PointsListInterface<PointInterface>
     */
    public function removePoint(PointInterface $point): PointsListInterface;

    /**
     * @param PointInterface $point
     *
     * @return bool
     */
    public function pointExists(PointInterface $point): bool;
}
