<?php

namespace KDTree\Interfaces;

interface NodeInterface
{
    /**
     * @return int
     */
    public function getDimension(): int;

    /**
     * @param int $dimension
     *
     * @return NodeInterface
     */
    public function setDimension(int $dimension): NodeInterface;

    /**
     * @return PointInterface
     */
    public function getPoint(): PointInterface;

    /**
     * @param PointInterface $point
     *
     * @return NodeInterface
     */
    public function setPoint(PointInterface $point): NodeInterface;

    /**
     * @return NodeInterface
     */
    public function getLeft(): NodeInterface;

    /**
     * @param NodeInterface $node
     *
     * @return NodeInterface
     */
    public function setLeft(NodeInterface $node): NodeInterface;

    /**
     * @return NodeInterface
     */
    public function getRight(): NodeInterface;

    /**
     * @param NodeInterface $node
     *
     * @return NodeInterface
     */
    public function setRight(NodeInterface $node): NodeInterface;
}
