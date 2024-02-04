<?php

namespace Parallelism;

use Enums\SocketMessageType;
use Exception;
use Ping\Ping;
use Websockets\WebsocketMessenger;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/BaseTask.php';
require_once __DIR__ . '/../Websockets/WebsocketMessenger.php';
require_once __DIR__ . '/../Ping/Ping.php';
require_once __DIR__ . '/../Dto/PingStatsDto.php';

class PingArrayTask extends BaseTask
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setIps(array $ips): void
    {
        $env = $_ENV;

        $this->taskToExecute = function () use ($env, $ips) {
//            Seems like to run another php instance, we need to require all the classes again.
            require_once __DIR__ . '/../Enums/SocketMessageType.php';
            require_once __DIR__ . '/../Dto/PingStatsDto.php';
            require_once __DIR__ . '/../Ping/Ping.php';
            require_once __DIR__ . '/../Websockets/WebsocketMessenger.php';

            $_ENV = $env;
            $WebsocketMessenger = new WebsocketMessenger();

            foreach ($ips as $ip) {
                echo "[ONGOING] Ping server trying to proceed IP: " . $ip['ip_address'] . "\n";
                try {
                    $ping = new Ping($ip['ip_address'], $_ENV['PING_TRY_BY_HOST'], $_ENV['PING_TIMEOUT_IN_MS']);
                    $ipPingDTO = $ping->ping();
//            (new IpRepository())->updateIP($ip['id'], $ipPingDTO);
                    $socketMessageType = new SocketMessageType(SocketMessageType::UPDATE_IP);
                    $message = $WebsocketMessenger->formatMessage($socketMessageType, $ipPingDTO->toMessage());
                    $WebsocketMessenger->send($message);
                    echo "[OK] Ping server succeed to process IP: " . $ip['ip_address'] . "\n";
                } catch (Exception $e) {
                    echo "[FAIL] Ping server failed to process IP: " . $ip['ip_address'] . "\n";
                }
                flush();
            }
        };
    }
}