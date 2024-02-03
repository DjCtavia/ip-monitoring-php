<?php

namespace Parallelism;

use Exceptions\Parallelism\TaskAlreadyRunningException;
use Exceptions\Parallelism\TaskToExecuteNotSetException;
use parallel\Future;
use parallel\Runtime;

class BaseTask implements TaskInterface
{
    private runtime $runtime;
    private $taskToExecute;
    private ?future $future;

    public function __construct(callable $taskToExecute = null)
    {
        $this->runtime = new Runtime();
        $this->taskToExecute = $taskToExecute;
        $this->future = null;
    }

    /**
     * @throws TaskAlreadyRunningException|TaskToExecuteNotSetException
     */
    public function run(): void
    {
        if ($this->isRunning()) throw new TaskAlreadyRunningException();
        if ($this->taskToExecute === null) throw new TaskToExecuteNotSetException();
        $this->future = $this->runtime->run($this->taskToExecute);
    }

    public function stop(): void
    {
        if (!$this->isRunning()) return;
        $this->future->cancel();
    }

    public function isRunning(): bool
    {
        return ($this->future && !$this->future->cancelled() && !$this->future->done()) ?? false;
    }
}