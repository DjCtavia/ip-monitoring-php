<?php

namespace Parallelism;

class TaskList
{
    /**
     * @var array<TaskInterface>
     */
    private array $tasks = [];

    public function add(TaskInterface $task): void
    {
        $this->tasks[] = $task;
    }

    public function runAll(): void
    {
        array_walk($this->tasks, fn(TaskInterface $task) => $task->run());
    }

    public function stopAll(): void
    {
        array_walk($this->tasks, fn(TaskInterface $task) => $task->stop());
    }

    public function isTasksRunning(): bool
    {
        return array_reduce($this->tasks, fn($carry, $task) => $carry || $task->isRunning(), false);
    }
}