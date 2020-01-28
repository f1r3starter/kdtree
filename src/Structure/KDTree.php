<?php

declare(strict_types=1);

namespace KDTree\Structure;

use KDTree\Exceptions\{InvalidDimensionsCount, InvalidPointProvided, PointAlreadyExists, PointNotFound};
use KDTree\Interfaces\{KDTreeInterface, NodeInterface, PointInterface, PointsListInterface};

final class KDTree implements KDTreeInterface
{
    /**
     * @var NodeInterface|null
     */
    private $root;

    /**
     * @var int
     */
    private $dimensions;

    /**
     * @var int
     */
    private $size = 0;

    /**
     * @param int $dimensions
     *
     * @throws InvalidDimensionsCount
     */
    public function __construct(int $dimensions)
    {
        if ($dimensions < 1) {
            throw new InvalidDimensionsCount();
        }
        $this->dimensions = $dimensions;
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
        return $this->size;
    }

    /**
     * @param PointInterface $point
     *
     * @return KDTreeInterface
     * @throws PointAlreadyExists|InvalidPointProvided
     */
    public function put(PointInterface $point): KDTreeInterface
    {
        $this->root = $this->insertNode($this->root, $point, 0);
        ++$this->size;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function contains(PointInterface $point): bool
    {
        return $this->findPoint($point, $this->root, 0);
    }

    /**
     * @return PointsListInterface<PointInterface>
     * @throws InvalidDimensionsCount
     */
    public function points(): PointsListInterface
    {
        return $this->getAllPoints($this->root, new PointsList($this->dimensions));
    }

    /**
     * @param PointInterface $point
     *
     * @return KDTreeInterface
     * @throws PointNotFound
     */
    public function delete(PointInterface $point): KDTreeInterface
    {
        $this->root = $this->deletePoint($point, $this->root, 0);
        --$this->size;

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
     * @return NodeInterface
     * @throws PointAlreadyExists
     */
    private function insertNode(?NodeInterface $node, PointInterface $point, int $cuttingDimension): NodeInterface
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
    private function findMin(?NodeInterface $node, int $dimension, int $cuttingDimension): ?PointInterface
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
        $minimums = [
            $this->getPointAxis($leftMin, $dimension)  => $leftMin,
            $this->getPointAxis($rightMin, $dimension) => $rightMin,
            $current                                   => $node->getPoint(),
        ];
        $minKey = min(
            array_keys(
                array_filter($minimums)
            )
        );

        return $minimums[$minKey];
    }

    /**
     * @param PointInterface|null $point
     * @param int $dimension
     *
     * @return float|null
     */
    private function getPointAxis(?PointInterface $point, int $dimension): ?float
    {
        return null === $point ? null : $point->getDAxis($dimension);
    }

    /**
     * @param PointInterface $point
     * @param NodeInterface|null $node
     * @param int $cuttingDimension
     *
     * @return NodeInterface|null
     * @throws PointNotFound
     */
    private function deletePoint(PointInterface $point, ?NodeInterface $node, int $cuttingDimension): ?NodeInterface
    {
        if (null === $node) {
            throw new PointNotFound();
        }

        $nextDimension = ($cuttingDimension + 1) % $this->dimensions;

        if ($node->getPoint()->equals($point)) {
            if (null !== $node->getRight()) {
                $this->rebuildFoundNode($node, $node->getRight(), $cuttingDimension);
            } elseif (null !== $node->getLeft()) {
                $this->rebuildFoundNode($node, $node->getLeft(), $cuttingDimension);
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

    /**
     * @param NodeInterface $node
     * @param NodeInterface $nextNode
     * @param int $cuttingDimension
     *
     * @throws PointNotFound
     */
    private function rebuildFoundNode(NodeInterface $node, NodeInterface $nextNode, int $cuttingDimension): void
    {
        $nextDimension = ($cuttingDimension + 1) % $this->dimensions;
        $point = $this->findMin($nextNode, $cuttingDimension, $nextDimension);

        if (null === $point) {
            return;
        }

        $node->setPoint($point);
        $node->setRight($this->deletePoint($point, $nextNode, $nextDimension));
    }

    /**
     * @param PointInterface $point
     * @param NodeInterface|null $node
     * @param int $cuttingDimension
     *
     * @return bool
     */
    private function findPoint(PointInterface $point, ?NodeInterface $node, int $cuttingDimension): bool
    {
        if (null === $node) {
            return false;
        }

        $nextDimension = ($cuttingDimension + 1) % $this->dimensions;

        if ($node->getPoint()->equals($point)) {
            return true;
        }

        if ($point->getDAxis($cuttingDimension) < $node->getPoint()->getDAxis($cuttingDimension)) {
            return $this->findPoint($point, $node->getLeft(), $nextDimension);
        }

        return $this->findPoint($point, $node->getRight(), $nextDimension);
    }

    /**
     * @param NodeInterface|null                  $node
     * @param PointsListInterface<PointInterface> $pointsList
     *
     * @return PointsListInterface<PointInterface>
     */
    private function getAllPoints(?NodeInterface $node, PointsListInterface $pointsList): PointsListInterface
    {
        if (null === $node) {
            return $pointsList;
        }

        $pointsList->addPoint($node->getPoint());

        if (null !== $node->getLeft()) {
            $this->getAllPoints($node->getLeft(), $pointsList);
        }

        if (null !== $node->getRight()) {
            $this->getAllPoints($node->getRight(), $pointsList);
        }

        return $pointsList;
    }
}
