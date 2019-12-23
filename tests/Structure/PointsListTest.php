<?php

namespace Structure;

use KDTree\Exceptions\InvalidDimensionsCount;
use KDTree\Exceptions\InvalidPointProvided;
use KDTree\Exceptions\PointNotFound;
use KDTree\Interfaces\PointsListInterface;
use KDTree\Structure\PointsList;
use KDTree\ValueObject\Point;
use PHPUnit\Framework\TestCase;

class PointsListTest extends TestCase
{
    public function testConstructAndIterate(): void
    {
        $pointsList = $this->preparePointsList();

        $this->assertCount(3, $pointsList);
        foreach ($pointsList as $key => $point) {
            $this->assertEquals(implode('_', $point->getAxises()), $key);
        }
    }

    public function testPointExists(): void
    {
        $pointsList = $this->preparePointsList();

        $this->assertTrue($pointsList->pointExists(new Point(1, 1)));
        $this->assertFalse($pointsList->pointExists(new Point(99, 99)));
    }

    public function testInvalidDimensionsCount(): void
    {
        $this->expectException(InvalidDimensionsCount::class);
        new PointsList(0);
    }

    public function testDifferentDimensionsPoint(): void
    {
        $pointsList = $this->preparePointsList();
        $this->expectException(InvalidPointProvided::class);

        $pointsList->addPoint(new Point(1, 2, 3));
    }

    public function testPointAddSuccess(): void
    {
        $pointsList = $this->preparePointsList();
        $point = new Point(9, 10);
        $this->assertFalse($pointsList->pointExists($point));

        $pointsList->addPoint($point);
        $this->assertTrue($pointsList->pointExists($point));
    }

    public function testPointRemoveSuccess(): void
    {
        $pointsList = $this->preparePointsList();
        $point = new Point(1, 1);
        $this->assertTrue($pointsList->pointExists($point));

        $pointsList->removePoint($point);
        $this->assertFalse($pointsList->pointExists($point));
    }

    public function testPointNotExistsWhileRemove(): void
    {
        $pointsList = $this->preparePointsList();
        $point = new Point(99, 99);
        $this->expectException(PointNotFound::class);

        $pointsList->removePoint($point);
    }

    private function preparePointsList(): PointsListInterface
    {
        return (new PointsList(2))
            ->addPoint(new Point(1, 1))
            ->addPoint(new Point(2, 2))
            ->addPoint(new Point(3, 3));
    }
}
