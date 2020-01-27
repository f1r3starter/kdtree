<?php

declare(strict_types=1);

namespace KDTree\Structure;

use KDTree\{Exceptions\InvalidDimensionsCount,
    Exceptions\InvalidPointProvided,
    Exceptions\PointNotFound,
    Interfaces\PointInterface,
    Interfaces\PointsListInterface};

final class PointsList implements PointsListInterface
{
    /**
     * @var int
     */
    private $dimensions;

    /**
     * @var PointInterface[]
     */
    private $container = [];

    /**
     * @param int $dimensions
     *
     * @throws InvalidDimensionsCount
     */
    public function __construct(int $dimensions)
    {
        if ($dimensions < 1) {
            throw new InvalidDimensionsCount();
        }
        $this->dimensions = $dimensions;
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        next($this->container);
    }

    /**
     * @inheritDoc
     */
    public function key(): ?string
    {
        return key($this->container);
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return null !== $this->current();
    }

    /**
     * @inheritDoc
     */
    public function current(): ?PointInterface
    {
        return current($this->container) instanceof PointInterface ? current($this->container) : null;
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        reset($this->container);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->container);
    }

    /**
     * @return int
     */
    public function getDimensions(): int
    {
        return $this->dimensions;
    }

    /**
     * @param PointInterface $point
     *
     * @return PointsListInterface<PointInterface>
     * @throws InvalidPointProvided
     */
    public function addPoint(PointInterface $point): PointsListInterface
    {
        if ($point->getDimensions() !== $this->dimensions) {
            throw new InvalidPointProvided();
        }
        $this->container[$this->prepareKey($point)] = $point;

        return $this;
    }

    /**
     * @param PointInterface $point
     *
     * @return PointsListInterface<PointInterface>
     * @throws PointNotFound
     */
    public function removePoint(PointInterface $point): PointsListInterface
    {
        if (!$this->pointExists($point)) {
            throw new PointNotFound();
        }
        unset($this->container[$this->prepareKey($point)]);

        return $this;
    }

    /**
     * @param PointInterface $point
     *
     * @return bool
     */
    public function pointExists(PointInterface $point): bool
    {
        return isset($this->container[$this->prepareKey($point)]);
    }

    /**
     * @param PointInterface $point
     *
     * @return string
     */
    private function prepareKey(PointInterface $point): string
    {
        return implode('_', $point->getAxises());
    }
}
