<?php

namespace Enums;

use MyCLabs\Enum\Enum;

require_once __DIR__ . '/../../vendor/autoload.php';

class IPTypeEnum extends Enum
{
    const IPV4 = "IPV4";
    const IPV6 = "IPV6";
}