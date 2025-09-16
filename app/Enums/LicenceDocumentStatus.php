<?php

declare(strict_types=1);

namespace App\Enums;

enum LicenceDocumentStatus
{
    case NOT_NECESSARY;
    case PENDING;
    case REJECTED;
    case ACCEPTED;
}
