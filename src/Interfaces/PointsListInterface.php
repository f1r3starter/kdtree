<?php

namespace KDTree\Interfaces;

interface PointsListInterface extends \Iterator, \Countable
{
    public function getDimensions(): int;

    public function addPoint(PointInterface $point): PointsListInterface;

    public function removePoint(PointInterface $point): PointsListInterface;

    public function pointExists(PointInterface $point): bool;
}
