<?php

namespace Tests;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../websockets/Messenger/WebsocketMessenger.php';

use Symfony\Component\Dotenv\Dotenv;
use websockets\Messenger\WebsocketMessenger;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../../.env');

echo "[TEST] Sending WebSocket message on port:" . $_ENV['WS_SERVER_PORT'] . "\n";
define("MESSAGE_TEST", json_encode(['type' => 'test', 'data' => 'Testing the message of sockets']));
WebsocketMessenger::send(MESSAGE_TEST);