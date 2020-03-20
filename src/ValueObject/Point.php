<?php

namespace KDTree\ValueObject;

use KDTree\Exceptions\{InvalidDimensionsCount, InvalidPointProvided, UnknownDimension};
use KDTree\Interfaces\PointInterface;

/**
 * Class Point
 *
 * @package KDTree\ValueObject
 */
final class Point implements PointInterface
{
    /**
     * @var string
     */
    private $name = '';

    /**
     * @var int
     */
    private $dimensions;

    /**
     * @var float[]
     */
    private $axises;

    /**
     * @param float ...$axises
     *
     * @throws InvalidDimensionsCount
     */
    public function __construct(float ...$axises)
    {
        $dimensions = count($axises);
        if ($dimensions < 1) {
            throw new InvalidDimensionsCount();
        }
        $this->dimensions = $dimensions;
        $this->axises = $axises;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return PointInterface
     */
    public function setName(string $name): PointInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param PointInterface $point
     *
     * @return float
     * @throws InvalidPointProvided
     */
    public function distance(PointInterface $point): float
    {
        if ($point->getDimensions() !== $this->getDimensions()) {
            throw new InvalidPointProvided();
        }

        $result = array_reduce(
            range(0, $this->dimensions - 1),
            function (float $result, int $dimension) use ($point): float {
                return $result + ($point->getDAxis($dimension) - $this->getDAxis($dimension)) ** 2;
            },
            0.0
        );

        return sqrt($result);
    }

    /**
     * @inheritDoc
     */
    public function getDimensions(): int
    {
        return $this->dimensions;
    }

    /**
     * @param int $dimension
     *
     * @return float
     * @throws UnknownDimension
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

    /**
     * @inheritDoc
     */
    public function getAxises(): array
    {
        return $this->axises;
    }
}
