<?php

namespace ValueObject;

use KDTree\Exceptions\InvalidDimensionsCount;
use KDTree\Exceptions\InvalidPointProvided;
use KDTree\Exceptions\UnknownDimension;
use KDTree\Interfaces\PointInterface;
use KDTree\ValueObject\Point;
use PHPUnit\Framework\TestCase;

final class PointTest extends TestCase
{
    public function testCorrectConstruction(): void
    {
        $points = [2.74, 3.75];
        $point = $this->preparePoint(...$points);
        $name = 'Test point';
        $point->setName($name);
        $this->assertEquals($points, $point->getAxises());
        $this->assertEquals(count($points), $point->getDimensions());
        $this->assertEquals($name, $point->getName());
        $this->assertEquals($points[0], $point->getDAxis(0));
        $this->assertEquals($points[1], $point->getDAxis(1));
    }

    public function testIncorrectPointsCount(): void
    {
        $this->expectException(InvalidDimensionsCount::class);
        $this->preparePoint();
    }

    public function testEquals(): void
    {
        $firstPointCoords = [23, 24];
        $secondPointCoords = [25, 26];

        $firstPoint = $this->preparePoint(...$firstPointCoords);
        $secondPoint = $this->preparePoint(...$secondPointCoords);
        $thirdPoint = $this->preparePoint(...$firstPointCoords);

        $this->assertFalse($firstPoint->equals($secondPoint));
        $this->assertTrue($firstPoint->equals($thirdPoint));
    }

    public function testUnknownDimension(): void
    {
        $point = $this->preparePoint(23, 24);
        $this->expectException(UnknownDimension::class);
        $point->getDAxis(3);
    }

    public function testDistance(): void
    {
        $firstPoint = $this->preparePoint(0, 0);
        $secondPoint = $this->preparePoint(5, 5);

        $this->assertEquals(7.0710678118654755, $firstPoint->distance($secondPoint));
    }

    public function testDifferentDimensionsCount(): void
    {
        $firstPoint = $this->preparePoint(0, 0);
        $secondPoint = $this->preparePoint(5, 5, 5);

        $this->expectException(InvalidPointProvided::class);
        $firstPoint->distance($secondPoint);
    }

    /**
     * @param float ...$points
     *
     * @return PointInterface
     * @throws InvalidDimensionsCount
     */
    private function preparePoint(float ...$points): PointInterface
    {
        return new Point(...$points);
    }
}
