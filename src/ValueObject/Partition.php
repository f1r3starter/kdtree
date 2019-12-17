<?php

namespace KDTree\ValueObject;

use KDTree\Exceptions\{InvalidPointsCount, UnknownDimension};
use KDTree\Interfaces\{PartitionInterface, PointInterface, PointsListInterface};

class Partition implements PartitionInterface
{
    /**
     * @var PointsListInterface
     */
    private $pointsList;

    /**
     * @var array
     */
    private $dMax;

    /**
     * @var array
     */
    private $dMin;

    /**
     * @param PointsListInterface $pointsList
     */
    public function __construct(PointsListInterface $pointsList)
    {
        $pointCount = count($pointsList);
        if (($pointCount & ($pointCount - 1)) !== 0) {
            throw new InvalidPointsCount();
        }

        $this->pointsList = $pointsList;

        $dMax = array_fill(0, $pointsList->getDimensions(), PHP_INT_MIN);
        $dMin = array_fill(0, $pointsList->getDimensions(), PHP_INT_MAX);
        foreach ($pointsList as $point) {
            foreach ($point->getAxises() as $d => $axis) {
                $dMax[$d] = max($dMax[$d], $axis);
                $dMin[$d] = min($dMin[$d], $axis);
            }
        }

        $this->dMax = $dMax;
        $this->dMin = $dMin;
    }

    /**
     * @inheritDoc
     */
    public function contains(PointInterface $point): bool
    {
        foreach ($point->getAxises() as $dimension => $axis) {
            if ($axis < $this->getDMin($dimension) || $axis > $this->getDMax($dimension)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getDMin(int $dimension): float
    {
        if (isset($this->dMin[$dimension])) {
            return $this->dMin[$dimension];
        }

        throw new UnknownDimension();
    }

    /**
     * @inheritDoc
     */
    public function getDMax(int $dimension): float
    {
        if (isset($this->dMax[$dimension])) {
            return $this->dMax[$dimension];
        }

        throw new UnknownDimension();
    }

    /**
     * @inheritDoc
     */
    public function intersects(PartitionInterface $partition): bool
    {
        foreach (range(0, $this->getDimensions() - 1) as $dimension) {
            $isIntersects = $this->getDMax($dimension) >= $partition->getDMin($dimension)
                && $partition->getDMax($dimension) >= $this->getDMin($dimension);

            if (false === $isIntersects) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getDimensions(): int
    {
        return $this->pointsList->getDimensions();
    }

    /**
     * @inheritDoc
     */
    public function distanceToPoint(PointInterface $point): float
    {
        $result = 0.0;
        foreach ($point->getAxises() as $dimension => $axis) {
            $len = 0.0;
            if ($axis < $this->getDMin($dimension)) {
                $len = $axis - $this->getDMin($dimension);
            } elseif ($axis > $this->getDMax($dimension)) {
                $len = $axis - $this->getDMax($dimension);
            }
            $result += $len ** 2;
        }

        return sqrt($result);
    }

    /**
     * @inheritDoc
     */
    public function equals(PartitionInterface $partition): bool
    {
        if ($partition->getDimensions() !== $this->getDimensions()) {
            return false;
        }

        foreach (range(0, $this->getDimensions() - 1) as $dimension) {
            if ($this->getDMin($dimension) !== $partition->getDMin($dimension)
                || $this->getDMax($dimension) !== $partition->getDMax($dimension)) {
                return false;
            }
        }

        return true;
    }
}
