<?php

namespace Structure;

use KDTree\Structure\Node;
use KDTree\ValueObject\Point;
use PHPUnit\Framework\TestCase;

final class NodeTest extends TestCase
{
    public function testConstruction(): void
    {
        $point = new Point(1, 2);
        $node = new Node($point);

        $this->assertEquals($point, $node->getPoint());
    }

    public function testPointSetter(): void
    {
        $node = new Node(new Point(1, 2));
        $newPoint = new Point(0, 0);
        $node->setPoint($newPoint);

        $this->assertEquals($newPoint, $node->getPoint());
    }

    public function testLeafSetters(): void
    {
        $node = new Node(new Point(1, 2));
        $nodeLeft = new Node(new Point(0, 0));
        $nodeRight = new Node(new Point(3, 3));
        $node->setRight($nodeRight);
        $node->setLeft($nodeLeft);

        $this->assertEquals($nodeLeft, $node->getLeft());
        $this->assertEquals($nodeRight, $node->getRight());
    }
}
