<?php

namespace utils;

use enums\IPTypeEnum;

require_once __DIR__ . '/../enums/IPTypeEnum.php';

class IPValidator
{
    private string $ip;
    private IPTypeEnum $ipType;

    public function __construct($ip)
    {
        $this->ip = $ip;
        $this->validateIP();
    }

    private function validateIP(): void
    {
        if (filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $this->ipType = IPTypeEnum::IPV6;
        } elseif (filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $this->ipType = IPTypeEnum::IPV6;
        } else {
            die(["error" => "Invalid IP address: {$this->ip}"]);
        }
    }

    public function getIP(): string
    {
        return $this->ip;
    }

    public function getIPType(): IPTypeEnum
    {
        return $this->ipType;
    }

    public function getIPTypeString(): string
    {
        return $this->ipType->value;
    }
}