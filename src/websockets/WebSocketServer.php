<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use enums\SocketMessageType;
use ip\IPPingDTO;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;


final class WebSocketServer implements MessageComponentInterface
{
    private SplObjectStorage $clients;

    public function __construct()
    {
        $this->clients = new SplObjectStorage;
    }

    #[Override]
    function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        echo "New connection: ({$conn->resourceId})\n";
    }

    #[Override]
    function onMessage(ConnectionInterface $from, $msg)
    {
        if ($_ENV['DEBUG']) {
            echo "Message from ({$from->resourceId}): {$msg}\n";
        }
    }

    #[Override]
    function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    #[Override]
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    function updateIP(IPPingDTO $ipPingDTO): void
    {
        $message = json_encode(['type' => SocketMessageType::UPDATE_IP, 'data' => $ipPingDTO]);

        foreach ($this->clients as $con) {
            $con->send($message);
        }
    }
}