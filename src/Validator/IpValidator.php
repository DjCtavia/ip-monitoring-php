<?php

namespace Validator;

use Enums\IPTypeEnum;

require_once __DIR__ . '/ValidatorInterface.php';
require_once __DIR__ . '/../Enums/IPTypeEnum.php';

class IpValidator implements ValidatorInterface
{
    private string $ip;
    private IPTypeEnum $ipType;

    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    public function validate(): bool
    {
        $isIPv4 = filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        $isIPv6 = filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);

        if ($isIPv4 || $isIPv6) {
            $this->ipType = $isIPv4 ? new IPTypeEnum(IPTypeEnum::IPV4) : new IPTypeEnum(IPTypeEnum::IPV6);
            return true;
        }
        return false;
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
        return $this->ipType->getValue();
    }
}