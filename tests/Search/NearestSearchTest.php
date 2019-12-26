<?php

namespace Search;

use KDTree\Interfaces\KDTreeInterface;
use KDTree\Search\NearestSearch;
use KDTree\Structure\KDTree;
use KDTree\ValueObject\Point;
use PHPUnit\Framework\TestCase;

class NearestSearchTest extends TestCase
{
    public function testConstruction(): void
    {
        $nearestSearch = new NearestSearch($this->prepareKdTree());

        $this->assertEquals(PHP_INT_MAX, $nearestSearch->getNearestDistance());
    }

    /**
     * @dataProvider nearestProvider
     */
    public function testFindNearest(array $point, array $nearest, float $distance): void
    {
        $nearestSearch = new NearestSearch($this->prepareKdTree());

        $point = $nearestSearch->nearest(new Point(...$point));
        $this->assertEquals($nearest, $point->getAxises());
        $this->assertEquals($distance, $nearestSearch->getNearestDistance());
    }

    /**
     * @return \Generator
     */
    public function nearestProvider(): \Generator
    {
        yield 'another point' => [
            'point' => [1, 1],
            'nearest' => [1, 3],
            'distance' => 2.0
        ];

        yield 'existing point' => [
            'point' => [9, 1],
            'nearest' => [9, 1],
            'distance' => 0.0
        ];
    }

    /**
     * @return KDTreeInterface
     */
    private function prepareKdTree(): KDTreeInterface
    {
        $kdTree = new KDTree(2);
        $kdTree->put(new Point(1, 3))
            ->put(new Point(4, 5))
            ->put(new Point(9, 1));

        return $kdTree;
    }
}
