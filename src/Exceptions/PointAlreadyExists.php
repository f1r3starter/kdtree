<?php

declare(strict_types=1);

namespace KDTree\Exceptions;

final class PointAlreadyExists extends \LogicException
{
    /**
     * @var string
     */
    protected $message = 'Point already exists';
}
