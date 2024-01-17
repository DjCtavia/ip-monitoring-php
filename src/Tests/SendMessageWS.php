<?php

namespace Tests;

use websockets\Messenger\WebsocketMessenger;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../websockets/Messenger/WebsocketMessenger.php';

const WS_SERVER_PORT = 5353;

echo "[TEST] Sending WebSocket message on port:" . WS_SERVER_PORT . "\n";
define("MESSAGE_TEST", json_encode(['type' => 'test', 'data' => 'Testing the message of sockets']));
WebsocketMessenger::send(MESSAGE_TEST);