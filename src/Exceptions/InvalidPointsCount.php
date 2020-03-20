<?php

declare(strict_types=1);

namespace KDTree\Exceptions;

use InvalidArgumentException;

/**
 * Class InvalidPointsCount
 *
 * @package KDTree\Exceptions
 */
final class InvalidPointsCount extends InvalidArgumentException
{
    /**
     * @var string
     */
    protected $message = 'Invalid point number provided';
}
