<?php

declare(strict_types=1);

namespace App\View;

use Twig\Environment;
use App\Service\Http\Session\Session;
use Twig\Loader\FilesystemLoader;

final class View
{
    private Environment $twig;

    public function __construct(private Session $session)
    {
        $loader = new FilesystemLoader('../templates');
        $this->twig = new Environment($loader);
        $this->session = $session;
    }

    public function render(array $data): string
    {
        $data['data']['session'] = $this->session->getAll();
        $data['data']['flashes'] = $this->session->getFlashes();
        $this->twig->addGlobal('_session', $_SESSION);
        $this->twig->addGlobal('_post', $_POST);
        $this->twig->addGlobal('_get', $_GET);

        return $this->twig->render("frontoffice/${data['template']}.html.twig", $data['data']);
    }
    public function renderAdmin(array $data): string
    {
        $data['data']['session'] = $this->session->getAll();
        $data['data']['flashes'] = $this->session->getFlashes();
        $this->twig->addGlobal('_session', $_SESSION);
        $this->twig->addGlobal('_post', $_POST);
        $this->twig->addGlobal('_get', $_GET);

        return $this->twig->render("backoffice/${data['template']}.html.twig", $data['data']);
    }
}
