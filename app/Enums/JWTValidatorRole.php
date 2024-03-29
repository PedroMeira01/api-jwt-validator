<?php

declare(strict_types=1);

namespace App\Enums;

enum JWTValidatorRole: string
{
    case ADMIN = 'Admin';
    case MEMBER = 'Member';
    case EXTERNAL = 'External';
}
