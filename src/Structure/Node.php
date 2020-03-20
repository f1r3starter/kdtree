<?php

declare(strict_types=1);

namespace KDTree\Structure;

use KDTree\{Interfaces\NodeInterface, Interfaces\PointInterface};

/**
 * Class Node
 *
 * @package KDTree\Structure
 */
final class Node implements NodeInterface
{
    /**
     * @var PointInterface
     */
    private $point;

    /**
     * @var NodeInterface|null
     */
    private $left;

    /**
     * @var NodeInterface|null
     */
    private $right;

    /**
     * @param PointInterface $point
     */
    public function __construct(PointInterface $point)
    {
        $this->point = $point;
    }

    /**
     * @inheritDoc
     */
    public function getPoint(): PointInterface
    {
        return $this->point;
    }

    /**
     * @inheritDoc
     */
    public function setPoint(PointInterface $point): NodeInterface
    {
        $this->point = $point;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLeft(): ?NodeInterface
    {
        return $this->left;
    }

    /**
     * @inheritDoc
     */
    public function setLeft(?NodeInterface $node): NodeInterface
    {
        $this->left = $node;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRight(): ?NodeInterface
    {
        return $this->right;
    }

    /**
     * @inheritDoc
     */
    public function setRight(?NodeInterface $node): NodeInterface
    {
        $this->right = $node;

        return $this;
    }
}
