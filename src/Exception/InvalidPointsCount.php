<?php

declare(strict_types=1);

namespace KDTree\Exceptions;

class InvalidPointsCount extends \InvalidArgumentException
{
    protected $message = 'Invalid point number provided';
}
