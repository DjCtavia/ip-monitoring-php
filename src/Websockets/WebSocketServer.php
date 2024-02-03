<?php

namespace Websockets;

use Dto\IPPingDto;
use Enums\SocketMessageType;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use SplObjectStorage;

require_once __DIR__ . '/../../vendor/autoload.php';

final class WebSocketServer implements MessageComponentInterface
{
    private SplObjectStorage $clients;

    public function __construct()
    {
        $this->clients = new SplObjectStorage;
    }

    function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        echo "New connection: ({$conn->resourceId})\n";
    }

    function onMessage(ConnectionInterface $from, $msg)
    {
        if ($_ENV['DEBUG']) {
            echo "Message from ({$from->resourceId}): {$msg}\n";
        }
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    function updateIP(IPPingDto $ipPingDTO): void
    {
        $message = json_encode(['type' => SocketMessageType::UPDATE_IP, 'data' => $ipPingDTO]);

        foreach ($this->clients as $con) {
            $con->send($message);
        }
    }
}