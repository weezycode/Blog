<?php

declare(strict_types=1);

namespace App\Model\Entity;

interface UserStatus
{
    const member   = 'member';
    const admin = 'admin';
    const superadmin = 'superadmin';
}
