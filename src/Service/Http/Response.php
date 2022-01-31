<?php

declare(strict_types=1);

namespace App\Service\Http;

use App\View\View;

final class Response
{
    private View $view;
    public function __construct(
        private string $content = '',
        private int $statusCode = 200,
        private array $headers = []
    ) {
    }

    public function send(): void
    {
        //echo $this->statusCode . ' ' . implode(',', $this->headers); 
        echo $this->content;
    }

    public function redirectingLost()
    {
        header('Location: index.php?action=perdu');
    }
}
