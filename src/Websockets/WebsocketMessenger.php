<?php

namespace Websockets;

use Enums\SocketMessageType;
use WebSocket\Client;

require_once __DIR__ . '/../../vendor/autoload.php';

class WebsocketMessenger
{
    private const WS_SERVER_PORT = 5353;

    public static function send(string $message): void
    {
        $client = new Client('ws://localhost:' . self::WS_SERVER_PORT, [
            'headers' => [
                'Origin' => 'localhost',
            ]
        ]);
        $client->text($message);
    }

    public static function formatMessage(SocketMessageType $type, $data): string
    {
        return json_encode(['type' => $type->getValue(), 'message' => $data]);
    }
}