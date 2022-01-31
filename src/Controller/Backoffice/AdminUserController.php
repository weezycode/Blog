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

    public function __construct(private Request $request, private UserRepository $userRepository, private View $view, private Session $session)
    {
        $this->infoUser = $this->request->getAllRequest();
    }

    public function displayAllUser()
    {
        $isUser = new AccessControl($this->session, $this->view);
        $redirecting = new Route($this->view);
        if (!$isUser->isAdmin()) {
            $redirecting->redirecting();
        }
        $isAdmin = $this->session->get('user');

        if ($isAdmin->getStatus() === 'admin' || $isAdmin->getStatus() === 'superadmin') {

            $users = $this->userRepository->findUser();

            return new Response($this->view->renderAdmin([
                'template' => 'userList',
                'data' => ['users' => $users],

            ]));
        } else {
            return $redirecting->redirecting();
        }
    }

    public function displayAllUserSupra()
    {
        $isUser = new AccessControl($this->session, $this->view);
        $redirecting = new Route($this->view);
        if (!$isUser->isAdmin()) {
            $redirecting->redirecting();
        }
        $isAdmin = $this->session->get('user');

        if ($isAdmin->getStatus() === 'superadmin') {

            $users = $this->userRepository->findUser();

            return new Response($this->view->renderAdmin([
                'template' => 'superAdminPage',
                'data' => ['users' => $users],

            ]));
        } else {

            return $redirecting->redirecting();
        }
    }
    public function AdmindeleteUser(Request $request)
    {
        $userConnect = new AccessControl($this->session, $this->view);
        $route = new Route($this->view);

        if ($userConnect->noConnect()) {
            return $route->redirecting();
        }

        if ($request->getMethod() === 'POST') {

            $idUser = $request->getRequest('idUser');
            $isAdmin = $this->session->get('user');
            if ($isAdmin->getStatus() === 'admin' || $isAdmin->getStatus() === 'superadmin') {
                $this->userRepository->delete($idUser);
                $this->session->addFlashes('success', 'Le membre a été supprimé !');
                if ($isAdmin->getStatus() === 'admin') {
                    return $route->userList();
                }
                if ($isAdmin->getStatus() === 'superadmin') {
                    return $route->userListSuperAdmin();
                }
            }
        }
        return $route->userList();
    }

    public function updateUser(Request $request)
    {
        $isUser = new AccessControl($this->session, $this->view);
        $route = new Route($this->view);
        if (!$isUser->isAdmin()) {
            $route->redirecting();
        }

        $isAdmin = $this->session->get('user');

        if ($isAdmin->getStatus() === 'superadmin') {
            if ($request->getRequest("changeToAdmin")) {
                $userToAdmin = $request->getRequest('changeToAdmin');
                $status = "admin";
                $this->userRepository->updateStatusUser($userToAdmin, $status);
                $this->session->addFlashes('success', "L'utilisateur est devenu Admin !");
                return $route->userListSuperAdmin();
            } elseif ($request->getRequest("changeToMember")) {
                $userToMember = $request->getRequest('changeToMember');
                $status = "member";
                $this->userRepository->updateStatusUser($userToMember, $status);
                $this->session->addFlashes('success', "L'utilisateur est devenu membre !");
                return $route->userListSuperAdmin();
            }
            return $route->userListSuperAdmin();
        }
        return $route->redirecting();
    }
}
