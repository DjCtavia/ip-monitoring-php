<?php

namespace Tests\ping;

use ping\Exception\PingFailedException;
use ping\Ping;

require_once __DIR__ . '/../../ping/Ping.php';

echo "[TEST] Ping on localhost\n";
$localhostPing = new Ping('localhost');
try {
    echo $localhostPing->ping() . "\n\n";
} catch (PingFailedException $e) {
    echo $e->getMessage() . "\n\n";
}

echo "[TEST] Ping on bad IP\n";
$badIpPing = new Ping('192.192.192.192');
try {
    echo $badIpPing->ping() . "\n\n";
} catch (PingFailedException $e) {
    echo $e->getMessage() . "\n\n";
}

echo "[TEST] Ping on 8.8.8.8 IP\n";
$otherPing = new Ping('8.8.8.8');
try {
    echo $otherPing->ping() . "\n\n";
} catch (PingFailedException $e) {
    echo $e->getMessage() . "\n\n";
}