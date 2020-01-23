<?php

declare(strict_types=1);

namespace KDTree\Exceptions;

final class UnknownDimension extends \InvalidArgumentException
{
    /**
     * @var string
     */
    protected $message = 'Unknown dimension';
}
