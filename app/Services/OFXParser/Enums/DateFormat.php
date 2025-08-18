<?php

declare(strict_types=1);

namespace App\Services\OFXParser\Enums;

enum DateFormat: string
{
    case DATE = 'Ymd';
    case DATETIME = 'YmdHis';
}
