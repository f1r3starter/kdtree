<?php

declare(strict_types=1);

namespace KDTree\Interfaces;

/**
 * Interface NearestSearchInterface
 *
 * @package KDTree\Interfaces
 */
interface NearestSearchInterface
{
    /**
     * @param PointInterface $point
     *
     * @return PointInterface|null
     */
    public function nearest(PointInterface $point): ?PointInterface;

    /**
     * @return float
     */
    public function getNearestDistance(): float;
}
