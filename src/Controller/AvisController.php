<?php

namespace App\Controller;

use App\Model\AvisManager;

class AvisController extends AbstractController
{
    public function index()
    {
        $avisManager = new AvisManager();
        $avis = $avisManager->selectAll();

        return $this->twig->render('Avis/index.html.twig', ['avis' => $avis]);
    }


    public function show(int $id)
    {
        $avisManager = new AvisManager();
        $avis = $avisManager->selectOneById($id);

        return $this->twig->render('Avis/show.html.twig', ['avis' => $avis]);
    }

    public function edit(int $id): string
    {
        $avisManager = new AvisManager();
        $avis = $avisManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $avis['nom'] = $_POST['nom'];
            $avis['titre'] = $_POST['titre'];
            $avis['note'] = $_POST['note'];
            $avis['commentaire'] = $_POST['commentaire'];

            $avisManager->update($avis);
        }

            return $this->twig->render('Avis/edit.html.twig', ['avis' => $avis]);
    }

    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $avisManager = new AvisManager();
            $avis = [
                    'nom' => $_POST['nom'],
                    'titre' => $_POST['titre'],
                    'note' => $_POST['note'],
                    'commentaire' => $_POST['commentaire'],
            ];
            $id = $avisManager->insert($avis);
            header('Location:/avis/show/' . $id);
        }

            return $this->twig->render('Avis/add.html.twig');
    }

    public function delete(int $id)
    {
        $avisManager = new AvisManager();
        $avisManager->delete($id);
        header('Location:/avis/index');
    }
}
