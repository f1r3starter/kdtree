<?php

declare(strict_types=1);

namespace KDTree\Search;

use KDTree\Interfaces\{KDTreeInterface, NodeInterface, PartitionInterface, PointsListInterface, RangeSearchInterface};

class RangeSearch implements RangeSearchInterface
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
     * @inheritDoc
     */
    public function range(PartitionInterface $partition): PointsListInterface
    {
        $pointsList = new PointsList($this->tree->getDimensions());
        $this->rangeAdd($this->tree->getRoot(), $partition, $pointsList);

        return $pointsList;
    }

    /**
     * @param NodeInterface|null $node
     * @param PartitionInterface $partition
     * @param PointsListInterface $pointsList
     */
    private function rangeAdd(
        ?NodeInterface $node,
        PartitionInterface $partition,
        PointsListInterface $pointsList
    ): void {
        if (null !== $node) {
            if ($partition->contains($node->getPoint())) {
                $pointsList->addPoint($node->getPoint());
            }

            $this->rangeAdd($node->getLeft(), $partition, $pointsList);
            $this->rangeAdd($node->getRight(), $partition, $pointsList);
        }
    }
}
