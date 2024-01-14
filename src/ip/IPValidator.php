<?php

namespace ip;

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
        $isIPv4 = filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        $isIPv6 = filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);

        if ($isIPv4 || $isIPv6) {
            $this->ipType = $isIPv4 ? IPTypeEnum::IPV4 : IPTypeEnum::IPV6;
        } else {
            die(json_encode(['status' => 'error', 'message' => "Invalid IP address: {$this->ip}"]));
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