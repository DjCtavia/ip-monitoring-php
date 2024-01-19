<?php

namespace ping;

class PingStatsDTO
{
    private int $sentPackets;
    private int $receivedPackets;
    private int $lostPackets;
    private int $lostPercentage;
    private int $minTime;
    private int $maxTime;
    private int $averageTime;

    public function __construct(
        int $sentPackets,
        int $receivedPackets,
        int $lostPackets,
        int $lostPercentage,
        int $minTime,
        int $maxTime,
        int $averageTime
    )
    {
        $this->sentPackets = $sentPackets;
        $this->receivedPackets = $receivedPackets;
        $this->lostPackets = $lostPackets;
        $this->lostPercentage = $lostPercentage;
        $this->minTime = $minTime;
        $this->maxTime = $maxTime;
        $this->averageTime = $averageTime;
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
}
