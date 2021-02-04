<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Controller\UserController;

class LoginController extends AbstractController
{

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $user =
                [
                    'username' => $_POST['username'],
                    'password' => $_POST['password']
                ];
            $login = $userManager->login($user);

            if (is_array($login)) {
                $_SESSION['username'] = $login['username'];
                $_SESSION['email'] = $login['email'];
                $_SESSION['password'] = $login['password'];
                $_SESSION['firstname'] = $login['firstname'];
                $_SESSION['lastname'] = $login['lastname'];
                $_SESSION['number'] = $login['number'];
                $_SESSION['use_admin'] = $login['use_admin'];
                $_SESSION['id'] = $login['id'];
                header('Location:/');
            } else {
                header('Location:/Login/login');
            }
        }
        return $this->twig->render('Login/login.html.twig');
    }

    public function logout()
    {
        if ($_SESSION) {
            $_SESSION = array();
            session_destroy();
            unset($_SESSION);
        }
        header('Location:/');
    }
}
