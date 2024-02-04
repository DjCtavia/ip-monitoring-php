<?php

use Enums\SocketMessageType;
use Parallelism\PingArrayTask;
use Parallelism\TaskList;
use Ping\Ping;
use Repository\IpRepository;
use Symfony\Component\Dotenv\Dotenv;
use Websockets\WebsocketMessenger;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Repository/IpRepository.php';
require_once __DIR__ . '/../Ping/Ping.php';
require_once __DIR__ . '/../Enums/SocketMessageType.php';
require_once __DIR__ . '/../Websockets/WebsocketMessenger.php';
require_once __DIR__ . '/../Parallelism/TaskList.php';
require_once __DIR__ . '/../Parallelism/PingArrayTask.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../../.env');

$WebsocketMessenger = new WebsocketMessenger();

echo "Ping server started processing\n";

try {
    $taskList = new TaskList();
    for ($i = 0; $i < $_ENV['NUMBER_OF_PING_PARALLEL_TASKS']; $i++) {
        $taskList->addTask(new PingArrayTask());
    }
} catch (Exception $e) {
    die($e->getMessage());
}

while (true) {
    $pingOffsetIndex = 0;
    while ($ipList = (new IpRepository())->getIPList($_ENV['PING_BATCH_SIZE'], $pingOffsetIndex++)) {
        $task = null;

        /** @var null|PingArrayTask $task */
        while (($task = $taskList->findTaskNotRunning()) === null) usleep($_ENV['WAIT_FOR_PARALLEL_TASKS_IN_MICROSECONDS']);
        $task->setIps($ipList);
        $task->run();
    }
    usleep($_ENV['DELAY_BETWEEN_PINGS_IN_MICROSECONDS']);
}