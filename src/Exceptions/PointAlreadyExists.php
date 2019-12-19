<?php

declare(strict_types=1);

namespace KDTree\Exceptions;

class PointAlreadyExists extends \LogicException
{
    protected $message = 'Point already exists';
}
