<?php

use enums\SocketMessageType;
use Ping\Ping;
use Repository\IpRepository;
use Symfony\Component\Dotenv\Dotenv;
use websockets\Messenger\WebsocketMessenger;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Repository/IpRepository.php';
require_once __DIR__ . '/../ping/Ping.php';
require_once __DIR__ . '/../enums/SocketMessageType.php';
require_once __DIR__ . '/../websockets/Messenger/WebsocketMessenger.php';
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../../.env');

echo "Ping server started processing\n";

while (true) {
    $pingOffsetIndex = 0;
    while ($ipList = (new IpRepository())->getIPList($_ENV['PING_BATCH_SIZE'], $pingOffsetIndex++)) {
        foreach ($ipList as $ip) {
            echo "[ONGOING] Ping server trying to proceed IP: " . $ip['ip_address'] . "\n";
            try {
                $ipPingDTO = (new Ping($ip['ip_address'], $_ENV['PING_TRY_BY_HOST'], $_ENV['PING_TIMEOUT_IN_MS']))->ping();
//            (new IpRepository())->updateIP($ip['id'], $ipPingDTO);
                WebsocketMessenger::send(WebsocketMessenger::formatMessage(SocketMessageType::UPDATE_IP, $ipPingDTO));
                echo "[OK] Ping server succeed to process IP: " . $ip['ip_address'] . "\n";
            } catch (Exception $e) {
                echo "[FAIL] Ping server failed to process IP: " . $ip['ip_address'] . "\n";
            }
        }
    }
    usleep($_ENV['DELAY_BETWEEN_PINGS_IN_MS']);
}