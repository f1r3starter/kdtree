<?php

namespace Search;

use Generator;
use KDTree\Exceptions\InvalidDimensionsCount;
use KDTree\Exceptions\InvalidPointProvided;
use KDTree\Exceptions\PointAlreadyExists;
use KDTree\Interfaces\KDTreeInterface;
use KDTree\Search\NearestSearch;
use KDTree\Structure\KDTree;
use KDTree\ValueObject\Point;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

class NearestSearchTest extends TestCase
{
    public function testConstruction(): void
    {
        $nearestSearch = new NearestSearch($this->prepareKdTree());

        $this->assertEquals(PHP_INT_MAX, $nearestSearch->getNearestDistance());
    }

    /**
     * @dataProvider nearestProvider
     *
     * @param array $point
     * @param array $nearest
     * @param float $distance
     *
     * @throws InvalidDimensionsCount|InvalidPointProvided|PointAlreadyExists|ExpectationFailedException|InvalidArgumentException
     */
    public function testFindNearest(array $point, array $nearest, float $distance): void
    {
        $nearestSearch = new NearestSearch($this->prepareKdTree());

        $point = $nearestSearch->nearest(new Point(...$point));
        $this->assertEquals($nearest, $point->getAxises());
        $this->assertEquals($distance, $nearestSearch->getNearestDistance());
    }

    /**
     * @return Generator
     */
    public function nearestProvider(): Generator
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
     * @throws InvalidDimensionsCount|InvalidPointProvided|PointAlreadyExists
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
