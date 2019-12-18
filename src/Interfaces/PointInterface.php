<?php

declare(strict_types=1);

namespace KDTree\Interfaces;

interface PointInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     *
     * @return PointInterface
     */
    public function setName(string $name): PointInterface;

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
     * @return float
     */
    public function distance(PointInterface $point): float;

    /**
     * @param PointInterface $point
     *
     * @return bool
     */
    public function equals(PointInterface $point): bool;
}
