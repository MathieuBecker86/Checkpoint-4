<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

class HomeController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->render('Home/index.html.twig');
    }

    public function partenaire()
    {
        return $this->twig->render('Home/partenaire.html.twig');
    }

    public function quijesuis()
    {
        return $this->twig->render('Home/quijesuis.html.twig');
    }

    public function nosengagements()
    {
        return $this->twig->render('Home/nosengagements.html.twig');
    }

}
