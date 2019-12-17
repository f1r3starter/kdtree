<?php

declare(strict_types=1);

namespace KDTree\Search;

use KDTree\Interfaces\{KDTreeInterface, NearestSearchInterface, NodeInterface, PointInterface};

class NearestSearch implements NearestSearchInterface
{
    /**
     * @var KDTreeInterface
     */
    private $tree;

    /**
     * @var int
     */
    private $visited = 0;

    /**
     * @var PointInterface|null
     */
    private $closestPoint;

    /**
     * @var float
     */
    private $bestDistance = PHP_INT_MAX;

    /**
     * @param KDTreeInterface $tree
     */
    public function __construct(KDTreeInterface $tree)
    {
        $this->tree = $tree;
    }

    /**
     * @param PointInterface $point
     *
     * @return PointInterface|null
     */
    public function nearest(PointInterface $point): ?PointInterface
    {
        $this->bestDistance = PHP_INT_MAX;
        $this->closestPoint = null;
        $this->findNearest($this->tree->getRoot(), $point);

        return $this->closestPoint;
    }

    /**
     * @param NodeInterface|null $node
     * @param PointInterface $searchingPoint
     * @param int $cuttingDimension
     */
    private function findNearest(?NodeInterface $node, PointInterface $searchingPoint, int $cuttingDimension = 0): void
    {
        if (null === $node) {
            return;
        }

        ++$this->visited;
        $distance = $node->getPoint()->distance($searchingPoint);

        if (null === $this->closestPoint || $distance < $this->bestDistance) {
            $this->bestDistance = $distance;
            $this->closestPoint = $node->getPoint();
        }

        if (0 === $this->bestDistance) {
            return;
        }

        $dx = $node->getPoint()->getDAxis($cuttingDimension) - $searchingPoint->getDAxis($cuttingDimension);
        $cuttingDimension = ($cuttingDimension + 1) % $this->tree->getDimensions();

        $this->findNearest($dx > 0 ? $node->getLeft() : $node->getRight(), $searchingPoint, $cuttingDimension);
        if ($dx * $dx >= $this->bestDistance) {
            return;
        }

        $this->findNearest($dx > 0 ? $node->getRight() : $node->getLeft(), $searchingPoint, $cuttingDimension);
    }

    /**
     * @return float
     */
    public function getNearestDistance(): float
    {
        return $this->bestDistance;
    }
}
