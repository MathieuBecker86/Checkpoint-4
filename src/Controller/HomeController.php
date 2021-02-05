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

    public function formation()
    {
        return $this->twig->render('Home/formation.html.twig');
    }

    public function presentation()
    {
        return $this->twig->render('Home/presentation.html.twig');
    }

    public function experiences()
    {
        return $this->twig->render('Home/experiences.html.twig');
    }

}
