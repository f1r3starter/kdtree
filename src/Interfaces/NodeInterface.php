<?php

declare(strict_types=1);

namespace KDTree\Interfaces;

/**
 * Interface NodeInterface
 *
 * @package KDTree\Interfaces
 */
interface NodeInterface
{
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
     * @return NodeInterface|null
     */
    public function getLeft(): ?NodeInterface;

    /**
     * @param NodeInterface|null $node
     *
     * @return NodeInterface
     */
    public function setLeft(?NodeInterface $node): NodeInterface;

    /**
     * @return NodeInterface|null
     */
    public function getRight(): ?NodeInterface;

    /**
     * @param NodeInterface|null $node
     *
     * @return NodeInterface
     */
    public function setRight(?NodeInterface $node): NodeInterface;
}
