<?php

namespace App\Controller;

use App\Service\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Menu $menu)
    {
        return $this->render('home/index.html.twig',[
            'menu' => $menu
        ]);
    }

}
