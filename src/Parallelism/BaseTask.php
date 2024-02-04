<?php

namespace Parallelism;

use Exceptions\Parallelism\TaskAlreadyRunningException;
use Exceptions\Parallelism\TaskToExecuteNotSetException;
use parallel\Future;
use parallel\Runtime;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/TaskInterface.php';
require_once __DIR__ . '/../Exceptions/Parallelism/TaskAlreadyRunningException.php';
require_once __DIR__ . '/../Exceptions/Parallelism/TaskToExecuteNotSetException.php';

class BaseTask implements TaskInterface
{
    private runtime $runtime;
    protected $taskToExecute;
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