<?php

namespace Dto;

use DateTime;
use Enums\IPTypeEnum;

class IPPingDto extends IpDto
{
    protected bool $pingStatus;
    protected DateTime $timestamp;

    public function __construct(string $ip, IPTypeEnum $type,
                                bool   $pingStatus, DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        $this->pingStatus = $pingStatus;
        parent::__construct($ip, $type);
    }
}