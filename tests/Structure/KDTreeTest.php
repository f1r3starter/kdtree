<?php

namespace Structure;

use KDTree\Exceptions\InvalidDimensionsCount;
use KDTree\Exceptions\PointAlreadyExists;
use KDTree\Exceptions\PointNotFound;
use KDTree\Structure\KDTree;
use KDTree\ValueObject\Point;
use PHPUnit\Framework\TestCase;

final class KDTreeTest extends TestCase
{
    public function testEmptyConstruction(): void
    {
        $dimensions = 2;
        $kdTree = new KDTree($dimensions);

        $this->assertEquals(0, $kdTree->size());
        $this->assertTrue($kdTree->isEmpty());
        $this->assertEquals($dimensions, $kdTree->getDimensions());
        $this->assertNull($kdTree->getRoot());
        $this->assertCount(0, $kdTree->points());
    }

    public function testInvalidDimensionsCount(): void
    {
        $this->expectException(InvalidDimensionsCount::class);
        new KDTree(0);
    }

    public function testPut(): void
    {
        $point = new Point(1, 1);
        $kdTree = new KDTree(2);
        $kdTree->put($point);

        $this->assertTrue($kdTree->contains($point));
        $this->assertEquals(1, $kdTree->size());
        $this->assertEquals($point, $kdTree->points()->current());
        $this->assertEquals($point, $kdTree->getRoot()->getPoint());

        $this->expectException(PointAlreadyExists::class);
        $kdTree->put($point);
    }

    public function testDelete(): void
    {
        $point = new Point(1, 1);
        $kdTree = new KDTree(2);
        $kdTree->put($point);
        $kdTree->delete($point);

        $this->assertFalse($kdTree->contains($point));
        for ($i = 0; $i <= 10; ++$i) {
            for ($j = 10; $j >= 0; --$j) {
                $kdTree->put(new Point($i, $j));
            }
        }

        $this->assertEquals(121, $kdTree->points()->count());

        for ($i = 0; $i <= 10; ++$i) {
            for ($j = 10; $j >= 0; --$j) {
                $kdTree->delete(new Point($i, $j));
            }
        }

        $this->assertEquals(1, $kdTree->points()->count());
        $kdTree->put(new Point(1, 1))
            ->put(new Point(2, 2))
            ->put(new Point(3, 3));

        $kdTree->delete(new Point(2, 2));

        $this->assertFalse($kdTree->contains(new Point(2, 2)));

        $this->expectException(PointNotFound::class);
        $kdTree->delete(new Point(999, 999));
    }
}
