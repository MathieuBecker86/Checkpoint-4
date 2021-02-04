<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function index()
    {
        $userManager = new UserManager();
        $users = $userManager->selectAll();

        return $this->twig->render('User/index.html.twig', ['users' => $users]);
    }

    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $user = [
                'username' => $_POST['username'],
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'number' => $_POST['number'],
                'password' => $_POST['password'],
            ];
            $id = $userManager->insert($user);
            header('Location:/Home/index/' . $id);
        }

        return $this->twig->render('User/add.html.twig');
    }

    public function show(int $id)
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        return $this->twig->render('User/show.html.twig', ['user' => $user]);
    }

    public function edit(int $id): string
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user['username'] = $_POST['username'];
            $user['firstname'] = $_POST['firstname'];
            $user['lastname'] = $_POST['lastname'];
            $user['email'] = $_POST['email'];
            $user['number'] = $_POST['number'];
            $user['password'] = $_POST['password'];
            $userManager->update($user);
        }

        return $this->twig->render('User/edit.html.twig', ['user' => $user]);
    }

    public function delete(int $id)
    {
        $userManager = new UserManager();
        $userManager->delete($id);
        header('Location:/Home/index');
    }
}
