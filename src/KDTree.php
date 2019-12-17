<?php

declare(strict_types=1);

namespace KDTree;

use KDTree\Exceptions\PointAlreadyExists;
use KDTree\Exceptions\PointNotFound;
use KDTree\Interfaces\{KDTreeInterface, NodeInterface, PointInterface, PointsListInterface};

class KDTree implements KDTreeInterface
{
    /**
     * @var PointsListInterface
     */
    private $points;

    /**
     * @var NodeInterface|null
     */
    private $root;

    /**
     * @var int
     */
    private $dimensions;

    /**
     * @param int $dimensions
     */
    public function __construct(int $dimensions)
    {
        $this->dimensions = $dimensions;
        $this->points = new PointsList($dimensions);
    }

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        return null === $this->root;
    }

    /**
     * @inheritDoc
     */
    public function size(): int
    {
        return $this->points->count();
    }

    /**
     * @inheritDoc
     */
    public function put(PointInterface $point): KDTreeInterface
    {
        if ($this->points->pointExists($point)) {
            throw new PointAlreadyExists();
        }

        $this->root = $this->insertNode($this->root, $point, 0);
        $this->points->addPoint($point);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function contains(PointInterface $point): bool
    {
        return $this->points->pointExists($point);
    }

    /**
     * @inheritDoc
     */
    public function points(): PointsListInterface
    {
        return $this->points;
    }

    /**
     * @inheritDoc
     */
    public function delete(PointInterface $point): KDTreeInterface
    {
        $this->deletePoint($point, $this->root, 0);
        $this->points->removePoint($point);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDimensions(): int
    {
        return $this->dimensions;
    }

    /**
     * @return NodeInterface|null
     */
    public function getRoot(): ?NodeInterface
    {
        return $this->root;
    }

    /**
     * @param NodeInterface|null $node
     * @param PointInterface $point
     * @param int $cuttingDimension
     *
     * @return NodeInterface|null
     */
    private function insertNode(?NodeInterface $node, PointInterface $point, int $cuttingDimension): ?NodeInterface
    {
        if (null === $node) {
            return new Node($point);
        }

        if ($node->getPoint()->equals($point)) {
            throw new PointAlreadyExists();
        }

        $nextDimension = ($cuttingDimension + 1) % $this->dimensions;

        if ($point->getDAxis($cuttingDimension) < $node->getPoint()->getDAxis($cuttingDimension)) {
            $node->setLeft($this->insertNode($node->getLeft(), $point, $nextDimension));
        } else {
            $node->setRight($this->insertNode($node->getRight(), $point, $nextDimension));
        }

        return $node;
    }

    /**
     * @param NodeInterface|null $node
     * @param int $dimension
     * @param int $cuttingDimension
     *
     * @return PointInterface|null
     */
    public function findMin(?NodeInterface $node, int $dimension, int $cuttingDimension): ?PointInterface
    {
        if (null === $node) {
            return null;
        }

        $nextDimension = ($cuttingDimension + 1) % $this->dimensions;
        if ($cuttingDimension === $dimension) {
            if (null === $node->getLeft()) {
                return $node->getPoint();
            }

            return $this->findMin(
                $node->getLeft(),
                $dimension,
                $nextDimension
            );
        }

        $leftMin = $this->findMin($node->getLeft(), $dimension, $nextDimension);
        $rightMin = $this->findMin($node->getRight(), $dimension, $nextDimension);
        $current = $node->getPoint()->getDAxis($dimension);
        $mins = array_filter([
                                 null !== $leftMin ? $leftMin->getDAxis($dimension) : null => $leftMin,
                                 null !== $rightMin ? $rightMin->getDAxis($dimension) : null => $rightMin,
                                 $current  => $node->getPoint(),
                             ]);
        $minKey = min(array_keys($mins));

        return $mins[$minKey];
    }

    /**
     * @param PointInterface $point
     * @param NodeInterface|null $node
     * @param int $cuttingDimension
     *
     * @return NodeInterface|null
     */
    private function deletePoint(PointInterface $point, ?NodeInterface $node, int $cuttingDimension): ?NodeInterface
    {
        if (null === $node) {
            throw new PointNotFound();
        }

        $nextDimension = ($cuttingDimension + 1) % $this->dimensions;

        if ($node->getPoint()->equals($point)) {
            if (null !== $node->getRight()) {
                $node->setPoint(
                    $this->findMin($node->getRight(), $cuttingDimension, $nextDimension)
                );
                $node->setRight($this->deletePoint($node->getPoint(), $node->getRight(), $nextDimension));
            } elseif (null !== $node->getLeft()) {
                $node->setPoint(
                    $this->findMin($node->getLeft(), $cuttingDimension, $nextDimension)
                );
                $node->setRight($this->deletePoint($node->getPoint(), $node->getLeft(), $nextDimension));
            } else {
                $node = null;
            }
        } elseif ($point->getDAxis($cuttingDimension) < $node->getPoint()->getDAxis($cuttingDimension)) {
            $node->setLeft($this->deletePoint($point, $node->getLeft(), $nextDimension));
        } else {
            $node->setRight($this->deletePoint($point, $node->getRight(), $nextDimension));
        }

        return $node;
    }
}
