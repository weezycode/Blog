<?php

declare(strict_types=1);

namespace  App\Service;

use PDO;
use App\View\View;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Controller\Frontoffice\Error404;
use App\Model\Repository\UserRepository;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\CommentRepository;
use App\Controller\Frontoffice\HomeController;
use App\Controller\Frontoffice\UserController;
use App\Controller\Frontoffice\ArticleController;

// TODO cette classe router est un exemple très basic. Cette façon de faire n'est pas optimale
// TODO Le router ne devrait pas avoir la responsabilité de l'injection des dépendances
final class Router
{
    private PDO $bdd;
    private View $view;
    private Session $session;


    public function __construct(private Request $request)
    {
        // dépendance21
        // $this->bdd = $database->getPDO();
        $this->database = new Database('localhost', 'root', '', 'blog');
        $this->session = new Session();
        $this->view = new View($this->session);
    }



    public function run(): Response
    {





        //On test si une action a été défini ? si oui alors on récupére l'action : sinon on mets une action par défaut (ici l'action posts)
        $action = $this->request->hasQuery('action') ? $this->request->getQuery('action') : 'home';

        //Déterminer sur quelle route nous sommes // Attention algorithme naïf
        // *** @Route http://localhost:8000/ ***


        // *** @Route http://localhost:8000/***
        if ($action === 'home') {
            $controller = new HomeController($this->view);

            return $controller->displayIndex();
        } elseif ($action === 'article') {

            $postRepo = new ArticleRepository($this->database);

            $controller = new ArticleController($postRepo, $this->view);


            return $controller->displayAllAction();

            // *** @Route http://localhost:8000/?action=comment&id=5 ***

        } elseif ($action === 'articledetails' && $this->request->hasQuery('id')) {

            $postRepo = new ArticleRepository($this->database);

            $controller = new ArticleController($postRepo, $this->view);

            $commentRepo = new CommentRepository($this->database);

            return $controller->displayOneAction((int) $this->request->getQuery('id'), $commentRepo);

            // *** @Route http://localhost:8000/?action=login ***
        } elseif ($action === 'login') {
            $userRepo = new UserRepository($this->database);
            $controller = new UserController($userRepo, $this->view, $this->session);

            return $controller->loginAction($this->request);

            // *** @Route http://localhost:8000/?action=logout ***
        } elseif ($action === 'logout') {
            $userRepo = new UserRepository($this->database);
            $controller = new UserController($userRepo, $this->view, $this->session);

            return $controller->logoutAction();

            // *** @Route http://localhost:8000/?action=sign ***

        } elseif ($action === 'sign') {
            $userRepo = new UserRepository($this->database);
            $controller = new UserController($userRepo, $this->view, $this->session);

            return $controller->signAction($this->request);
        } else {
            $controller = new Error404($this->view);
            return $controller->displayError();
            // return new Response("Error 404 - cette page n'existe pas<br><a href='index.php?action=posts'>Aller Ici</a>", 404);
        }
    }
}
