<?php

namespace websockets\Messenger;


use function Ratchet\Client\connect;

require_once __DIR__ . '/../../../vendor/autoload.php';

class WebsocketMessenger
{
    private const WS_SERVER_PORT = 5353;

    public static function send(string $message): void
    {
        connect('ws://localhost:' . self::WS_SERVER_PORT)->then(function ($conn) use ($message) {
            $conn->send($message);
            $conn->close();
        }, function ($e) {
            echo "[ERROR] Websocket Messenger: {$e->getMessage()}\n";
        });
    }
}