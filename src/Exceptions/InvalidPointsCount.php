<?php

declare(strict_types=1);

namespace KDTree\Exceptions;

final class InvalidPointsCount extends \InvalidArgumentException
{
    /**
     * @var string
     */
    protected $message = 'Invalid point number provided';
}
