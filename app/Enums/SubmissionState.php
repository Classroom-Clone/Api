<?php

declare(strict_types=1);

namespace App\Enums;

enum SubmissionState: string
{
    case ACTIVE = "active";
    case RETURNED = "returned";
    case RECLAIMED = "reclaimed";
    case EVALUATED = "evaluated";
}
