<?php

declare(strict_types=1);

namespace KDTree\Interfaces;

interface RangeSearchInterface
{
    /**
     * @param PartitionInterface $partition
     *
     * @return PointsListInterface
     */
    public function range(PartitionInterface $partition): PointsListInterface;
}
