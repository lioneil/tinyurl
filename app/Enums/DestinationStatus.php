<?php

namespace App\Enums;

use App\Enums\Enum;

abstract class DestinationStatus extends Enum
{
    const ACTIVE = 1;
    const EXPIRED = 2;
    const ARCHIVED = 3;
}
