<?php

declare(strict_types=1);

namespace KDTree\Exceptions;

final class InvalidDimensionsCount extends \InvalidArgumentException
{
    /**
     * @var string
     */
    protected $message = 'Invalid dimensions count';
}
