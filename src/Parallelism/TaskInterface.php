<?php

namespace Parallelism;

interface TaskInterface
{
    public function run();
    public function stop();
    public function isRunning();
}