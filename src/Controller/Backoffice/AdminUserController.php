<?php

declare(strict_types=1);

namespace  App\Controller\Backoffice;

use App\View\View;
use App\Service\Route;
use App\Service\Http\Request;
use App\Service\AccessControl;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Model\Repository\UserRepository;
use App\Controller\Frontoffice\Error404Controller;

final class AdminUserController
{

    public function __construct(private Request $request, private UserRepository $userRepository, private View $view, private Session $session, private AccessControl $access)
    {
        $this->infoUser = $this->request->getAllRequest();
    }

    public function displayAllUser()
    {
        $response = new response();
        if (!$this->access->isAdmin()) {
            $response->redirectTo("index.php");
        }

        $isAdmin = $this->session->get('user');

        if ($isAdmin->getStatus() === 'admin' || $isAdmin->getStatus() === 'superadmin') {

            $users = $this->userRepository->findUser();

            return new Response($this->view->renderAdmin([
                'template' => 'userList',
                'data' => ['users' => $users],

            ]));
        } else {
            $response->redirectTo("index.php");
        }
    }

    public function displayAllUserSupra()
    {
        $response = new response();
        if (!$this->access->isAdmin()) {
            $response->redirectTo("index.php");
        }
        $isAdmin = $this->session->get('user');

        if ($isAdmin->getStatus() === 'superadmin') {

            $users = $this->userRepository->findUser();


            return new Response($this->view->renderAdmin([
                'template' => 'superAdminPage',
                'data' => [
                    'users' => $users
                ],

            ]));
        } else {

            return $response->redirecting();
        }
    }
    public function AdmindeleteUser(Request $request)
    {

        $response = new response();
        if ($this->access->noConnect()) {
            return $response->redirectTo("index.php");
        }

        if ($request->getMethod() === 'POST') {

            $idUser = $request->getRequest('idUser');
            $isAdmin = $this->session->get('user');
            if ($isAdmin->getStatus() === 'admin' || $isAdmin->getStatus() === 'superadmin') {
                $this->userRepository->delete($idUser);
                $this->session->addFlashes('success', 'Le membre a été supprimé !');
                if ($isAdmin->getStatus() === 'admin') {
                    return $response->redirectTo("index.php?action=displayAllUser");
                }
                if ($isAdmin->getStatus() === 'superadmin') {
                    return $response->redirectTo("index.php?action=superAdminPage");
                }
            }
        }
        return $response->redirectTo("index.php?action=displayAllUser");
    }

    public function updateUser(Request $request)
    {
        $response = new response();

        if (!$this->access->isAdmin()) {
            $response->redirectTo("index.php");
        }

        $isAdmin = $this->session->get('user');

        if ($isAdmin->getStatus() === 'superadmin') {
            if ($request->getRequest("changeToAdmin")) {
                $userToAdmin = $request->getRequest('changeToAdmin');
                $status = "admin";
                $this->userRepository->updateStatusUser($userToAdmin, $status);
                $this->session->addFlashes('success', "L'utilisateur est devenu éditeur !");
                return $response->redirectTo("index.php?action=superAdminPage");
            } elseif ($request->getRequest("changeToMember")) {
                $userToMember = $request->getRequest('changeToMember');
                $status = "member";
                $this->userRepository->updateStatusUser($userToMember, $status);
                $this->session->addFlashes('success', "L'utilisateur est devenu membre !");
                return $response->redirectTo("index.php?action=superAdminPage");
            }
            return $response->redirectTo("index.php?action=superAdminPage");
        }
        return $response->redirectTo("index.php");
    }
}
