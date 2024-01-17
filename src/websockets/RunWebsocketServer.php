<?php

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/WebSocketServer.php';


const WS_SERVER_PORT = 5353;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new WebSocketServer(true)
        )
    ),
    WS_SERVER_PORT
);

echo "WebSocket server starting on port " . WS_SERVER_PORT . "\n";

$server->run();