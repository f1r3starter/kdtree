<?php

namespace Structure;

use KDTree\Exceptions\InvalidDimensionsCount;
use KDTree\Exceptions\PointAlreadyExists;
use KDTree\Structure\KDTree;
use KDTree\ValueObject\Point;
use PHPUnit\Framework\TestCase;

class KDTreeTest extends TestCase
{
    public function testEmptyConstruction(): void
    {
        $dimensions = 2;
        $kdTree = new KDTree($dimensions);

        $this->assertEquals(0, $kdTree->size());
        $this->assertTrue($kdTree->isEmpty());
        $this->assertEquals($dimensions, $kdTree->getDimensions());
        $this->assertNull($kdTree->getRoot());
    }

    public function testInvalidDimensionsCount()
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
    }
}
