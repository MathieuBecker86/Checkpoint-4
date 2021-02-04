<?php

namespace App\Controller;

use App\Model\ItemManager;
use App\Model\ReservationManager;

class ReservationController extends AbstractController
{
    public function index()
    {
        $reservationManager = new ReservationManager();
        $reservations = $reservationManager->selectAll();

        return $this->twig->render('Reservation/index.html.twig', ['reservations' => $reservations]);
    }

    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id_client'])) {
            $reservationManager = new ReservationManager();
            $reservation = [
                'date' => $_POST['date'],
                'commentaire' => $_POST['commentaire'],
                'id_client' => $_POST['id_client'],
                'montant' => $_POST['montant'],
                'validation' => $_POST['validation'],
            ];
            $id = $reservationManager->insert($reservation);
            header('Location:/reservation/show/' . $id);
        }

        return $this->twig->render('Reservation/add.html.twig');
    }

    public function show(int $id)
    {
        $reservationManager = new ReservationManager();
        $reservation = $reservationManager->selectOneById($id);

        return $this->twig->render('Reservation/show.html.twig', ['reservation' => $reservation]);
    }

    public function edit(int $id): string
    {
        $reservationManager = new ReservationManager();
        $reservation = $reservationManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reservation['date'] = $_POST['date'];
            $reservationManager->update($reservation);
        }

        return $this->twig->render('Reservation/edit.html.twig', ['reservation' => $reservation]);
    }

    public function delete(int $id)
    {
        $reservationManager = new ReservationManager();
        $reservationManager->delete($id);
        header('Location:/reservation/index');
    }
}
