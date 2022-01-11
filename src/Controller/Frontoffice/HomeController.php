<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Http\Response;

final class HomeController
{
    public function __construct(private View $view)
    {
    }
    public function displayIndex(): Response
    {



        return new Response($this->view->render(['template' => 'home']));
    }
}
