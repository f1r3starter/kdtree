<?php

namespace KDTree\ValueObject;

use KDTree\Exceptions\InvalidPointProvided;
use KDTree\Exceptions\UnknownDimension;
use KDTree\Interfaces\PointInterface;

class Point implements PointInterface
{
    /**
     * @var int
     */
    private $dimensions;

    /**
     * @var array
     */
    private $axises;

    /**
     * Point constructor.
     * @param float ...$axises
     */
    public function __construct(float ...$axises)
    {
        $this->axises = $axises;
        $this->dimensions = count($axises);
    }

    /**
     * @inheritDoc
     */
    public function getDimensions(): int
    {
        return $this->dimensions;
    }

    /**
     * @inheritDoc
     */
    public function getAxises(): array
    {
        return $this->axises;
    }

    /**
     * @inheritDoc
     */
    public function getDAxis(int $dimension): float
    {
        if (isset($this->axises[$dimension])) {
            return $this->axises[$dimension];
        }

        throw new UnknownDimension();
    }

    /**
     * @inheritDoc
     */
    public function distance(PointInterface $point): float
    {
        if ($point->getDimensions() !== $this->getDimensions()) {
            throw new InvalidPointProvided();
        }

        $result = array_reduce(range(0, $this->dimensions - 1),
            function (float $result, int $dimension) use ($point) {
                return $result + ($point->getDAxis($dimension) - $this->getDAxis($dimension)) ** 2;
            },
        0.0
        );

        return sqrt($result);
    }

    /**
     * @inheritDoc
     */
    public function equals(PointInterface $point): bool
    {
        return $this->getAxises() === $point->getAxises();
    }
}
