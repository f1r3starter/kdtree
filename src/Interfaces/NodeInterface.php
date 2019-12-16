<?php

namespace KDTree\Interfaces;

interface NodeInterface
{
    /**
     * @return PointInterface
     */
    public function getPoint(): PointInterface;

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
