<?php

namespace ping;

use ping\Exception\PingFailedException;

require_once __DIR__ . '/Exception/PingFailedException.php';
require_once __DIR__ . '/PingStatsDTO.php';

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

    public function ping(): PingStatsDTO
    {
        $command = sprintf('ping -n %s -w %s %s', escapeshellarg($this->numberOfPing), escapeshellarg($this->timeoutInMS), escapeshellarg($this->host));

        exec($command, $output, $result);

        if ($result === 0) {
            return $this->extractData($output);
        }
        throw new PingFailedException($this->host);
    }

    private function extractData(array $output): PingStatsDTO
    {
        echo "base: " . print_r($output, true) . "\n\n";

        $packetsStatsLines = array_filter($output, fn($line) => str_contains($line, '%)'));
        preg_match('/: .+(\d).+(\d).+(\d).+(\d)/', implode("\n", $packetsStatsLines), $packetsStats);

        $durationStatsLines = array_filter($output, fn($line) => str_contains($line, '=') && str_contains($line, ',') && str_contains($line, 'ms'));
        preg_match('/.+(\d).+(\d).+(\d)/', implode("\n", $durationStatsLines), $durationStats);

        echo "Ping stats for " . $this->host . "\n";
        echo "Packets stats line: " . print_r($packetsStatsLines, true);
        echo "\nPackets stats: \n" . print_r($packetsStats, true) ."\n";
        echo "Duration stats line: " . print_r($durationStatsLines, true);
        echo "\nDurations stats: \n" . print_r($durationStats, true) ."\n";
        return new PingStatsDTO(
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