<?php

declare(strict_types=1);

namespace KDTree\Exceptions;

class UnknownDimension extends \InvalidArgumentException
{
    protected $message = 'Unknown dimension';
}
