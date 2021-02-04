<?php

namespace App\Controller;

use App\Model\ContactManager;

class ContactController extends AbstractController
{


    /**
     * Display item listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $contactManager = new ContactManager();
        $contact = $contactManager->selectAll();

        return $this->twig->render('Contact/index.html.twig', ['contact' => $contact]);
    }

    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contactManager = new ContactManager();
            $contact = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'message' => $_POST['message'],
            ];
            $id = $contactManager->insert($contact);
            header('Location:/Contact/show/' . $id);
        }

        return $this->twig->render('Contact/add.html.twig');
    }

    public function show(int $id)
    {
        $contactManager = new ContactManager();
        $contact = $contactManager->selectOneById($id);

        return $this->twig->render('Contact/show.html.twig', ['contact' => $contact]);
    }

    public function edit(int $id): string
    {
        $contactManager = new ContactManager();
        $contact = $contactManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contact['firstname'] = $_POST['firstname'];
            $contact['lastname'] = $_POST['lastname'];
            $contact['email'] = $_POST['email'];
            $contact['number'] = $_POST['number'];
            $contactManager->update($contact);
        }

        return $this->twig->render('Contact/edit.html.twig', ['contact' => $contact]);
    }

    public function delete(int $id)
    {
        $contactManager = new ContactManager();
        $contactManager->delete($id);
        header('Location:/Contact/index');
    }
}
