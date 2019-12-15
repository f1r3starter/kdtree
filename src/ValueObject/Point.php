<?php

namespace KDTree\ValueObject;

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
    public function equals(PointInterface $point): bool
    {
        return $this->getAxises() === $point->getAxises();
    }
}
