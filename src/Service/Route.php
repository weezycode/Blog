<?php

declare(strict_types=1);

namespace  App\Service;

use App\View\View;
use App\Service\Http\Response;


final class Route
{
    public function __construct(private View $view)
    {
    }
    // frontoffice
    public function displayIndex()
    {
        return new Response($this->view->render(['template' => 'home']));
    }


    public function displayError()
    {
        return new Response($this->view->render(['template' => 'error/404']));
    }

    public function signAction()
    {
        return new Response($this->view->render(['template' => 'sign', 'data' => []]));
    }

    public function loginAction()
    {
        return new Response($this->view->render(['template' => 'login', 'data' => []]));
    }

    public function deleteUser()
    {
        return new Response($this->view->render(['template' => 'deleteUser', 'data' => []]));
    }

    //backoffice

    public function Addpost()
    {
        return new Response($this->view->renderAdmin(['template' => 'addPost', 'data' => []]));
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
