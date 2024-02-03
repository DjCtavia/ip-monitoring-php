<?php

namespace Dto;

use Enums\IPTypeEnum;

class IpDto
{
    protected string $ip;
    protected IPTypeEnum $type;

    public function __construct(string $ip, IPTypeEnum $type)
    {
        $this->type = $type;
        $this->ip = $ip;
    }
}