<?php

declare(strict_types=1);

namespace  App\Service;

final class Token
{
    public function getToken()
    {
        $token = bin2hex(random_bytes(35));
        return $token;
    }
}
