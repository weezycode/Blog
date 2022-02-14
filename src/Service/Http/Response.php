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


    public function redirectTo(string $url)
    {
        header("Location: ${url}  ");
        exit;
    }

    public function redirectingLost()
    {
        header('Location: index.php?action=perdu');
    }

    // admin & usperadmin
    public function userList()
    {
        header('Location:index.php?action=displayAllUser');
    }
    //for only superadmin
    public function userListSuperAdmin()
    {
        header('Location:index.php?action=superAdminPage');
    }



    public function redirecting()
    {
        header('Location: index.php');
    }
    public function redirectingLogin()
    {
        header('Location: index.php?action=login');
    }

    public function redirectingPostcomment()
    {
        header('Location: index.php?action=article');
    }
}
