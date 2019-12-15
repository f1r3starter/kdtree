<?php

namespace KDTree\Interfaces;

interface PointInterface
{
    /**
     * @return int
     */
    public function getDimensions(): int;

    /**
     * @return array
     */
    public function getAxises(): array;

    /**
     * @param int $dimension
     *
     * @return float
     */
    public function getDAxis(int $dimension): float;

    /**
     * @param PointInterface $point
     *
     * @return bool
     */
    public function equals(PointInterface $point): bool;
}
