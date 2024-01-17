<?php

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/WebSocketServer.php';
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../../.env');
$_ENV['DEBUG'] = (bool)($_ENV['DEBUG'] ?? $_ENV['APP'] === 'dev');

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new WebSocketServer()
        )
    ),
    $_ENV['WS_SERVER_PORT']
);

echo "WebSocket server starting on port " . $_ENV['WS_SERVER_PORT'] . "\n";

$server->run();