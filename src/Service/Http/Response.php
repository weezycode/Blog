<?php

declare(strict_types=1);

namespace App\Service\Http;

final class Response
{
    public function __construct(
        private string $content = '',
        private int $statusCode = 200,
        private array $headers = []
    ) {
    }

    public function send(): void
    {
        // echo $this->statusCode . ' ' . implode(',', $this->headers); // TODO Il faut renvoyer aussi le status de la réponse
        echo $this->content;
    }
}
