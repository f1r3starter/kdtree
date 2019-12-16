<?php

namespace KDTree\Exceptions;

class PointAlreadyExists extends \LogicException
{
    protected $message = 'Point already exists';
}
