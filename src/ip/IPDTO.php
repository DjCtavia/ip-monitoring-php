<?php

namespace ip;

use enums\IPTypeEnum;

class IPDTO
{
    public function __construct(protected string $ip,
                                protected IPTypeEnum $type) {}
}