<?php

namespace Parallelism;

require_once __DIR__ . '/TaskInterface.php';

class TaskList
{
    /**
     * @var array<TaskInterface>
     */
    private array $tasks = [];

    public function addTask(TaskInterface $task): void
    {
        $this->tasks[] = $task;
    }

    public function executeTasks(): void
    {
        array_walk($this->tasks, fn(TaskInterface $task) => $task->run());
    }

    public function stopTasks(): void
    {
        array_walk($this->tasks, fn(TaskInterface $task) => $task->stop());
    }

    public function findTaskNotRunning(): ?TaskInterface
    {
        return array_reduce($this->tasks, fn($carry, $task) => $carry ?? ($task->isRunning() ? null : $task));
    }

    public function isTasksRunning(): bool
    {
        return array_reduce($this->tasks, fn($carry, $task) => $carry || $task->isRunning(), false);
    }
}