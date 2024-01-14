<?php

namespace ip;

use DateTime;
use enums\IPTypeEnum;

class IPPingDTO extends IPDTO
{
    public function __construct(string             $ip,
                                IPTypeEnum         $type,
                                protected bool     $pingStatus,
                                protected DateTime $timestamp)
    {
        parent::__construct($ip, $type);
    }
}