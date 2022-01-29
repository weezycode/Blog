<?php

declare(strict_types=1);

namespace  App\Service;

use PDO;
use App\View\View;
use App\Model\Entity\User;
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
use App\Controller\Frontoffice\CommentController;
use App\Controller\Frontoffice\ContactController;
use App\Controller\Backoffice\AdminUserController;
use App\Controller\Frontoffice\Error404Controller;
use App\Controller\backoffice\AdminArticleController;

// TODO cette classe router est un exemple très basic. Cette façon de faire n'est pas optimale
// TODO Le router ne devrait pas avoir la responsabilité de l'injection des dépendances
final class Router
{
    private PDO $bdd;
    private View $view;
    private Session $session;
    private $send;
    private $message;
    private  $user;


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
        } elseif ($action === 'contact') {

            $controller = new ContactController($this->request, $this->view, $this->session);

            return $controller->contactForm();
        } elseif ($action === 'article') {

            $userRepo = new UserRepository($this->database);
            $postRepo = new ArticleRepository($this->database);

            $controller = new ArticleController($postRepo, $this->view, $userRepo);


            return $controller->displayAllAction();

            // *** @Route http://localhost:8000/?action=comment&id=5 ***

        } elseif ($action === 'articledetails' && $this->request->hasQuery('id')) {

            $postRepo = new ArticleRepository($this->database);
            $userRepo = new UserRepository($this->database);
            $controller = new ArticleController($postRepo, $this->view, $userRepo);

            $commentRepo = new CommentRepository($this->database);
            return $controller->displayOneAction((int) $this->request->getQuery('id'), $commentRepo);

            // *** @Route http://localhost:8000/?action=login ***
        } elseif ($action === 'login') {
            $userRepo = new UserRepository($this->database);
            $controller = new UserController($this->request, $userRepo, $this->view, $this->session);

            return $controller->loginAction($this->request);

            // *** @Route http://localhost:8000/?action=logout ***
        } elseif ($action === 'addComment') {
            $userRepo = new UserRepository($this->database);
            $commentRepo = new CommentRepository($this->database);
            $postRepo = new ArticleRepository($this->database);
            $controller = new CommentController($this->request, $userRepo, $this->session, $commentRepo, $this->view, $postRepo);

            return $controller->addComment();

            // *** @Route http://localhost:8000/?action=logout ***
        } elseif ($action === 'logout') {
            $userRepo = new UserRepository($this->database);
            $controller = new UserController($this->request, $userRepo, $this->view, $this->session);

            return $controller->logoutAction();

            // *** @Route http://localhost:8000/?action=sign ***

        } elseif ($action === 'sign') {
            $userRepo = new UserRepository($this->database);
            $controller = new UserController($this->request, $userRepo, $this->view, $this->session);

            return $controller->signUpAction($this->request);
        } elseif ($action === 'deleteMember') {
            $userRepo = new UserRepository($this->database);
            $controller = new AdminUserController($this->request, $userRepo, $this->view, $this->session);
            return $controller->AdmindeleteUser($this->request);
        } elseif ($action === 'deleteMe') {
            $userRepo = new UserRepository($this->database);
            $controller = new UserController($this->request, $userRepo, $this->view, $this->session);
            return $controller->deleteUser($this->request);
        } elseif ($action === 'admin') {
            $userRepo = new UserRepository($this->database);
            $postRepo = new ArticleRepository($this->database);
            $controller = new AdminArticleController($postRepo, $this->view, $this->session, $this->request);

            return $controller->Admin();
        } elseif ($action === 'displayForUpdatePost' && $this->request->hasQuery('id')) {

            $postRepo = new ArticleRepository($this->database);
            $controller = new AdminArticleController($postRepo, $this->view, $this->session, $this->request);
            return $controller->displayForUpdatePost((int) $this->request->getQuery('id'));

            // *** @Route http://localhost:8000/?action=login ***
        } elseif ($action === 'updatePost') {
            $userRepo = new UserRepository($this->database);
            $postRepo = new ArticleRepository($this->database);
            $controller = new AdminArticleController($postRepo, $this->view, $this->session, $this->request);

            return $controller->updatePost();
        } elseif ($action === 'displayToAddPost') {
            $userRepo = new UserRepository($this->database);
            $postRepo = new ArticleRepository($this->database);
            $controller = new AdminArticleController($postRepo, $this->view, $this->session, $this->request);

            return $controller->displayToAddPost();
        } elseif ($action === 'addPost') {
            $userRepo = new UserRepository($this->database);
            $postRepo = new ArticleRepository($this->database);
            $controller = new AdminArticleController($postRepo, $this->view, $this->session, $this->request);

            return $controller->addPost();
        } elseif ($action === 'deletePost') {
            $userRepo = new UserRepository($this->database);
            $postRepo = new ArticleRepository($this->database);
            $controller = new AdminArticleController($postRepo, $this->view, $this->session, $this->request);

            return $controller->deletePost();
        } elseif ($action === 'displayAllUser') {
            $userRepo = new UserRepository($this->database);
            $controller = new AdminUserController($this->request, $userRepo, $this->view, $this->session);

            return $controller->displayAllUser();
        } elseif ($action === 'listComment') {
            $commentRepo = new CommentRepository($this->database);
            $postRepo = new ArticleRepository($this->database);
            $controller = new AdminArticleController($postRepo, $this->view, $this->session, $this->request);

            return $controller->displayAllComment($commentRepo);
        } elseif ($action === 'isGrantedComment') {
            $commentRepo = new CommentRepository($this->database);
            $postRepo = new ArticleRepository($this->database);
            $controller = new AdminArticleController($postRepo, $this->view, $this->session, $this->request);

            return $controller->updateCommentStatus($commentRepo);
        } elseif ($action === 'deleteComment') {
            $commentRepo = new CommentRepository($this->database);
            $postRepo = new ArticleRepository($this->database);
            $controller = new AdminArticleController($postRepo, $this->view, $this->session, $this->request);

            return $controller->deleteComment($commentRepo);
        } elseif ($action === 'superAdminPage') {
            $userRepo = new UserRepository($this->database);
            $controller = new AdminUserController($this->request, $userRepo, $this->view, $this->session);

            return $controller->displayAllUserSupra();
        } elseif ($action === 'changeStatusUser') {
            $userRepo = new UserRepository($this->database);
            $controller = new AdminUserController($this->request, $userRepo, $this->view, $this->session);

            return $controller->updateUser($this->request);
        } else {
            $controller = new Error404Controller($this->view);
            return $controller->displayError();
            // return new Response("Error 404 - cette page n'existe pas<br><a href='index.php?action=posts'>Aller Ici</a>", 404);
        }
    }
}
