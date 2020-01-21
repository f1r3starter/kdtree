<?php

declare(strict_types=1);

namespace KDTree\Exceptions;

class InvalidPointProvided extends \InvalidArgumentException
{
    /**
     * @var string
     */
    protected $message = 'Invalid point provided';
}
