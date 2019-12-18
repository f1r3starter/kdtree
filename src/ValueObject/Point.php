<?php

namespace KDTree\ValueObject;

use KDTree\Exceptions\{InvalidDimensionsCount, InvalidPointProvided, UnknownDimension};
use KDTree\Interfaces\PointInterface;

class Point implements PointInterface
{
    /**
     * @var string
     */
    private $id;

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
     *
     * @param string $id
     * @param float ...$axises
     */
    public function __construct(string $id, float ...$axises)
    {
        $dimensions = count($axises);
        if ($dimensions < 1) {
            throw new InvalidDimensionsCount();
        }
        $this->dimensions = $dimensions;
        $this->axises = $axises;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function distance(PointInterface $point): float
    {
        if ($point->getDimensions() !== $this->getDimensions()) {
            throw new InvalidPointProvided();
        }

        $result = array_reduce(
            range(0, $this->dimensions - 1),
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
    public function getDimensions(): int
    {
        return $this->dimensions;
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

    /**
     * @inheritDoc
     */
    public function getAxises(): array
    {
        return $this->axises;
    }
}
