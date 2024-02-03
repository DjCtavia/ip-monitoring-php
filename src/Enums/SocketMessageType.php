<?php

namespace Enums;

use MyCLabs\Enum\Enum;

require_once __DIR__ . '/../../vendor/autoload.php';

class SocketMessageType extends Enum
{
    const UPDATE_IP = 'update_ip';
}
