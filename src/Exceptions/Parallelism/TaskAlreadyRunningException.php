<?php

namespace Exceptions\Parallelism;

class TaskAlreadyRunningException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Task is already running");
    }
}