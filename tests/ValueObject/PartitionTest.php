<?php

namespace ValueObject;

use KDTree\Exceptions\InvalidDimensionsCount;
use KDTree\Exceptions\InvalidPointProvided;
use KDTree\Exceptions\InvalidPointsCount;
use KDTree\Exceptions\UnknownDimension;
use KDTree\Structure\PointsList;
use KDTree\ValueObject\Partition;
use KDTree\ValueObject\Point;
use PHPUnit\Framework\TestCase;

class PartitionTest extends TestCase
{
    public function testSuccessConstruction(): void
    {
        $partition = $this->preparePartition();

        $this->assertEquals(0, $partition->getDMin(0));
        $this->assertEquals(1, $partition->getDMin(1));
        $this->assertEquals(4, $partition->getDMax(0));
        $this->assertEquals(4, $partition->getDMax(1));
    }

    public function testFailConstruction(): void
    {
        $pointsList = new PointsList(2);
        $pointsList->addPoint(new Point(1, 2))
            ->addPoint(new Point(2, 1));
        $this->expectException(InvalidPointsCount::class);

        new Partition($pointsList);
    }

    /**
     * @param callable $fn
     *
     * @throws InvalidDimensionsCount|InvalidPointProvided|InvalidPointsCount
     * @dataProvider unknownDimensionProvider
     */
    public function testUnknownDimension(callable $fn): void
    {
        $partition = $this->preparePartition();

        $this->expectException(UnknownDimension::class);
        $fn($partition);
    }

    public function testIntersects(): void
    {
        $partition = $this->preparePartition();
        $pointsList = new PointsList(2);
        $pointsList->addPoint(new Point(0, 0))
            ->addPoint(new Point(0, 1))
            ->addPoint(new Point(1, 0))
            ->addPoint(new Point(1, 1));
        $partition2 = new Partition($pointsList);

        $this->assertTrue($partition->intersects($partition2));

        $pointsList = new PointsList(2);
        $pointsList->addPoint(new Point(66, 77))
            ->addPoint(new Point(77, 66))
            ->addPoint(new Point(55, 66))
            ->addPoint(new Point(44, 88));
        $partition3 = new Partition($pointsList);

        $this->assertFalse($partition->intersects($partition3));
    }

    public function testContains(): void
    {
        $partition = $this->preparePartition();

        $this->assertTrue($partition->contains(new Point(1, 1)));
        $this->assertFalse($partition->contains(new Point(666, 666)));
    }

    public function testDistanceToPoint(): void
    {
        $partition = $this->preparePartition();

        $this->assertEquals(87.681240867132, $partition->distanceToPoint(new Point(66, 66)));
        $this->assertEquals(140.71602609511, $partition->distanceToPoint(new Point(-99, -99)));
    }

    public function testEquals(): void
    {
        $partition = $this->preparePartition();
        $pointsList = new PointsList(1);
        $pointsList->addPoint(new Point(1))
                    ->addPoint(new Point(0));
        $oneDPartition = new Partition($pointsList);

        $this->assertFalse($partition->equals($oneDPartition));

        $pointsList = new PointsList(2);
        $pointsList->addPoint(new Point(1, 1))
            ->addPoint(new Point(0, 0))
            ->addPoint(new Point(0, 1))
            ->addPoint(new Point(1, 0));
        $partition2 = new Partition($pointsList);

        $this->assertFalse($partition->equals($partition2));
        $this->assertTrue($partition->equals($partition));
    }

    /**
     * @return \Generator
     */
    public function unknownDimensionProvider(): \Generator
    {
        yield 'min' => [
            'fn' => static function(Partition $partition) {
                $partition->getDMin(5);
            }
        ];

        yield 'max' => [
            'fn' => static function(Partition $partition) {
                $partition->getDMax(5);
            }
        ];
    }

    /**
     * @return Partition
     * @throws InvalidPointsCount|InvalidDimensionsCount|InvalidPointProvided
     */
    private function preparePartition(): Partition
    {
        $pointsList = new PointsList(2);
        $pointsList->addPoint(new Point(1, 2))
            ->addPoint(new Point(0, 3))
            ->addPoint(new Point(4, 1))
            ->addPoint(new Point(1, 4));

        return new Partition($pointsList);
    }
}
