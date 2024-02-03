<?php

namespace Dto;

class PingStatsDto
{
    private string $host;
    private int $sentPackets;
    private int $receivedPackets;
    private int $lostPackets;
    private int $lostPercentage;
    private int $minTime;
    private int $maxTime;
    private int $averageTime;
    private string $timestamp;

    public function __construct(
        string $host = null,
        int $sentPackets = null,
        int $receivedPackets = null,
        int $lostPackets = null,
        int $lostPercentage = null,
        int $minTime = null,
        int $maxTime = null,
        int $averageTime = null,
        string $timestamp = null
    )
    {
        $this->host = $host;
        $this->sentPackets = $sentPackets;
        $this->receivedPackets = $receivedPackets;
        $this->lostPackets = $lostPackets;
        $this->lostPercentage = $lostPercentage;
        $this->minTime = $minTime;
        $this->maxTime = $maxTime;
        $this->averageTime = $averageTime;
        $this->timestamp = $timestamp ?? date('Y-m-d H:i:s');
    }

    public function getSentPackets(): int
    {
        return $this->sentPackets;
    }

    public function getReceivedPackets(): int
    {
        return $this->receivedPackets;
    }

    public function getLostPackets(): int
    {
        return $this->lostPackets;
    }

    public function getLostPercentage(): int
    {
        return $this->lostPercentage;
    }

    public function getMinTime(): int
    {
        return $this->minTime;
    }

    public function getMaxTime(): int
    {
        return $this->maxTime;
    }

    public function getAverageTime(): int
    {
        return $this->averageTime;
    }

    // to string
    public function __toString(): string
    {
        return sprintf(
            'Sent packets: %s, Received packets: %s, Lost packets: %s, Lost percentage: %s, Min time: %sms, Max time: %sms, Average time: %sms',
            $this->sentPackets,
            $this->receivedPackets,
            $this->lostPackets,
            $this->lostPercentage,
            $this->minTime,
            $this->maxTime,
            $this->averageTime
        );
    }

    public function toMessage(): string
    {
        return json_encode([
            'host' => $this->host,
            'sentPackets' => $this->sentPackets,
            'receivedPackets' => $this->receivedPackets,
            'lostPackets' => $this->lostPackets,
            'lostPercentage' => $this->lostPercentage,
            'minTime' => $this->minTime,
            'maxTime' => $this->maxTime,
            'averageTime' => $this->averageTime,
            'timestamp' => $this->timestamp,
        ]);
    }
}
