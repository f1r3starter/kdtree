<?php

declare(strict_types=1);

namespace KDTree\Search;

use KDTree\Exceptions\InvalidDimensionsCount;
use KDTree\Interfaces\{KDTreeInterface,
    NodeInterface,
    PartitionInterface,
    PartitionSearchInterface,
    PointInterface,
    PointsListInterface};
use KDTree\Structure\PointsList;

/**
 * Class PartitionSearch
 *
 * @package KDTree\Search
 */
final class PartitionSearch implements PartitionSearchInterface
{
    /**
     * @var KDTreeInterface
     */
    private $tree;

    /**
     * @param KDTreeInterface $tree
     */
    public function __construct(KDTreeInterface $tree)
    {
        $this->tree = $tree;
    }

    /**
     * @param PartitionInterface $partition
     *
     * @return PointsListInterface<PointInterface>
     * @throws InvalidDimensionsCount
     */
    public function find(PartitionInterface $partition): PointsListInterface
    {
        $pointsList = new PointsList($this->tree->getDimensions());
        $this->partitionAdd($this->tree->getRoot(), $partition, $pointsList);

        return $pointsList;
    }

    /**
     * @param NodeInterface|null                  $node
     * @param PartitionInterface                  $partition
     * @param PointsListInterface<PointInterface> $pointsList
     */
    private function partitionAdd(
        ?NodeInterface $node,
        PartitionInterface $partition,
        PointsListInterface $pointsList
    ): void {
        if (null !== $node) {
            if ($partition->contains($node->getPoint())) {
                $pointsList->addPoint($node->getPoint());
            }

            $this->partitionAdd($node->getLeft(), $partition, $pointsList);
            $this->partitionAdd($node->getRight(), $partition, $pointsList);
        }
    }
}
