<?php

namespace KDTree\Interfaces;

interface PointsListInterface extends \Iterator, \Countable
{
    public function getDimensions(): int;
}
