<?php

namespace Ping;

use Dto\PingStatsDto;
use Exceptions\Ping\PingFailedException;

require_once __DIR__ . '/../Exceptions/Ping/PingFailedException.php';
require_once __DIR__ . '/../Dto/PingStatsDto.php';

class Ping
{
    private string $host;
    private int $numberOfPing;
    private int $timeoutInMS;

    public function __construct(string $host, int $numberOfPing = 5, int $timeoutInMS = 4000)
    {
        $this->host = $host;
        $this->numberOfPing = $numberOfPing;
        $this->timeoutInMS = $timeoutInMS;
    }

    public function ping(): PingStatsDto
    {
        $command = sprintf('ping -n %s -w %s %s', escapeshellarg($this->numberOfPing), escapeshellarg($this->timeoutInMS), escapeshellarg($this->host));

        exec($command, $output, $result);

        if ($result === 0) {
            return $this->extractData($this->host, $output);
        }
        throw new PingFailedException($this->host);
    }

    private function extractData(string $host, array $output): PingStatsDto
    {
        $packetsStatsLines = array_filter($output, fn($line) => str_contains($line, '%)'));
        preg_match('/: .+(\d).+(\d).+(\d).+(\d)/', implode("\n", $packetsStatsLines), $packetsStats);

        $durationStatsLines = array_filter($output, fn($line) => str_contains($line, '=') && str_contains($line, ',') && str_contains($line, 'ms'));
        preg_match('/.+(\d).+(\d).+(\d)/', implode("\n", $durationStatsLines), $durationStats);

        return new PingStatsDto(
            $host,
            (int) $packetsStats[1],
            (int) $packetsStats[2],
            (int) $packetsStats[3],
            (int) $packetsStats[4],
            (int) $durationStats[1],
            (int) $durationStats[2],
            (int) $durationStats[3],
        );
    }
}