<?php

declare(strict_types=1);

namespace KDTree\Exceptions;

class PointNotFound extends \LogicException
{
    protected $message = 'Point not found';
}
