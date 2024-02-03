<?php

namespace Exceptions\Parallelism;

class TaskToExecuteNotSetException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Task to execute is not set");
    }
}