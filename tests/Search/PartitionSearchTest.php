<?php

namespace Search;

use KDTree\Interfaces\KDTreeInterface;
use KDTree\Search\PartitionSearch;
use KDTree\Structure\KDTree;
use KDTree\Structure\PointsList;
use KDTree\ValueObject\Partition;
use KDTree\ValueObject\Point;
use PHPUnit\Framework\TestCase;

class PartitionSearchTest extends TestCase
{
    public function testSearch(): void
    {
        $partitionSearch = new PartitionSearch($this->prepareKdTree());
        $pointsList = new PointsList(2);
        $pointsList->addPoint(new Point(80, 80))
            ->addPoint(new Point(99, 99))
            ->addPoint(new Point(70, 70))
            ->addPoint(new Point(60, 70));
        $partition = new Partition($pointsList);

        $points = $partitionSearch->find($partition);
        $this->assertCount(1, $points);
        $this->assertEquals([91, 91], $points->current()->getAxises());
    }

    /**
     * @return KDTreeInterface
     */
    private function prepareKdTree(): KDTreeInterface
    {
        $kdTree = new KDTree(2);
        $kdTree->put(new Point(1, 1))
            ->put(new Point(3, 3))
            ->put(new Point(9, 9))
            ->put(new Point(91, 91))
            ->put(new Point(4, 4));

        return $kdTree;
    }
}
