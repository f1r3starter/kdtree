<?php

declare(strict_types=1);

namespace KDTree\Interfaces;

interface PartitionSearchInterface
{
    /**
     * @param PartitionInterface $partition
     *
     * @return PointsListInterface<PointInterface>
     */
    public function find(PartitionInterface $partition): PointsListInterface;
}
