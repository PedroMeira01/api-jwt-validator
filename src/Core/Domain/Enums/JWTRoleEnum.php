<?php

declare(strict_types=1);

namespace Core\Domain\Enums;

enum JWTRoleEnum: string
{
    case ADMIN = 'Admin';
    case MEMBER = 'Member';
    case EXTERNAL = 'External';
}
