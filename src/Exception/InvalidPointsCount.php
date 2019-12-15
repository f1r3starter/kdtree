<?php

namespace KDTree\Exceptions;

class InvalidPointsCount extends \InvalidArgumentException
{
    protected $message = 'Invalid point number provided';
}
